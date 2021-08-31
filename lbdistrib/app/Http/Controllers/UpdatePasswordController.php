<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    /*
     * Ensure the user is signed in to access this page
     */
    public function __construct() {

        $this->middleware('auth');

    }
    /**
     * Show the form to change the user password.
     */
    public function index(){
        return view('auth.change-password');
    }

    /**
     * Update the password for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::find(Auth::id());
        $hashedPassword = $user->password;

        if (Hash::check($request->old, $hashedPassword)) {
            //Change the password
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            $request->session()->flash('success', 'Su clave se cambió correctamente.');

            return back();
        }

        $request->session()->flash('failure', 'Su clave no pudo cambiarse.');

        return back();


    }
}
