<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;

use Auth;
use Hash;
use Session;
use DB;
use Carbon;
use Mail;

class PasswordController extends Controller
{
    public function sendPasswordResetToken(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ( !$user ){
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'No tenemos registro de su email ');
            Session::flash('alert-type', 'error');

            return redirect()->back();
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60), //change 60 to any length you want
            'created_at' => now()
        ]);

        $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

        $token = $tokenData->token;
        $email = $request->email;

        $destinatario   = $user->nombre.' '.$user->apellido;
        $email          = $user->email;
        $mensaje        = 'Puedes resetear tu clave haciendo click en el link';

        $data           = array('destinatario'=> $destinatario, 'mensaje' => $mensaje, 'token' => $token);

        Mail::send('email.resetpassword', $data, function($message) use ($destinatario, $email) {
            $message->to($email, $destinatario)->subject('Reset clave acceso');
        });

        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'Te hemos enviado un mail !');
        Session::flash('alert-type', 'success');

        return redirect()->back();

    }

    public function showPasswordResetForm($token){
        
        $tokenData = DB::table('password_resets')->where('token', $token)->first();

        if ( !$tokenData ){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Su clave es incorrecta ');
            Session::flash('alert-type', 'error');

            return redirect()->back();
        }
        
        return view('auth.passwords.reset', \compact('token'));
    }

    public function resetPassword(Request $request) {

        $user = User::where('email', $request->email)->first();

        if ( !$user ){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'No tenemos registro de su email ');
            Session::flash('alert-type', 'error');

        }else{

            if($request->password !== $request->password_confirmation){

                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', 'La clave nueva no coincide con su confirmación. Intente nuevamente');
                Session::flash('alert-type', 'error');

            }else{

                if(strlen($request->password) < 8 OR strlen($request->password_confirmation) < 8){

                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('message', 'Clave actual debe tener al menos 6 caracteres. Intente nuevamente');
                    Session::flash('alert-type', 'error');

                }else{

                    $user->password = bcrypt($request->get('password'));
                    $user->save();

                    Session::flash('message', 'Clave reestablecida correctamente !');
                    Session::flash('alert-class', 'alert-success');
                    Session::flash('alert-type', 'success');

                    DB::table('password_resets')->where('email', $user->email)->delete();
                }
            }
        }

        $token = $request->token;

        return view('auth.passwords.reset', \compact('token'));
    }
}
