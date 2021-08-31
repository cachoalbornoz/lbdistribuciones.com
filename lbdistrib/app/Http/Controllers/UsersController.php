<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\User,
    App\Models\Producto,
    Caffeinated\Shinobi\Models\Role;

use Image;

use Yajra\DataTables\Facades\DataTables;


class UsersController extends Controller
{

    public function index()
    {
        $users = User::orderBy('name', 'ASC')->get();
        return view('admin.users.index', compact('users'));
    }


    public function dataindex()
    {
        return view('admin.users.dataindex');
    }

    public function usersData(Producto $producto, Request $request)
    {

        $producto = Producto::all();
        return Datatables::of($producto)
            ->addColumn('action', function ($user) {
                return '<a href="#edit-' . $user->id . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->make();
    }

    //////

    public function buscar(Request $request)
    {
        $users     = User::where('type', $request->type)->orderBy('name', 'ASC')->get();
        $view      = view('admin.users.detalle', compact('users'))->render();
        return response()->json($view);
    }


    public function create()
    {
        $roles      = Role::get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        if ($request->file()) {
            $path = public_path() . '/images/upload/usuarios/';
            $file = $request->file('image');
            $name = $file->getClientOriginalName();

            $img = Image::make($file->getRealPath());

            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . '/' . $name);
        } else {
            $name = 'user.jpg';
        }

        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->image    = $name;
        $user->save();


        //actualizar roles
        $user->roles()->sync($request->get('roles'));

        $notification = array(
            'message' => 'Usuario se ha creado correctamente !',
            'alert-type' => 'success'
        );


        return redirect()->route('users.edit', $user->id)->with($notification);
    }

    public function edit(User $user)
    {
        $roles      = Role::get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->file()) {
            $path   = public_path() . '/images/upload/usuarios/';

            if (\File::exists($path . $user->image)) {
                \File::delete($path . $user->image);
            }

            $file = $request->file('image');
            $name = $file->getClientOriginalName();

            $img = Image::make($file->getRealPath());

            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . '/' . $name);
        } else {
            $name = $user->image;
        }

        $user->fill($request->all());
        $user->image = $name;
        $user->save();

        //actualizar roles
        $user->roles()->sync($request->get('roles'));

        $notification = array(
            'message' => 'Usuario se ha actualizado correctamente !',
            'alert-type' => 'success'
        );


        return redirect()->route('users.edit', $user->id)->with($notification);
    }

    public function editProfile($id)
    {
        $user = User::find($id);

        return view('admin.users.editprofile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->id);

        if ($request->file()) {
            $path   = public_path() . '/images/upload/usuarios/';

            if (\File::exists($path . $user->image)) {
                \File::delete($path . $user->image);
            }

            $file = $request->file('image');
            $name = $file->getClientOriginalName();

            $img = Image::make($file->getRealPath());

            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . '/' . $name);
        } else {
            $name = $user->image;
        }

        $user->fill($request->all());
        $user->image = $name;
        $user->save();

        $notification = array(
            'message' => 'Perfil actualizado correctamente !',
            'alert-type' => 'success'
        );

        return redirect()->route('users.editprofile', $user->id)->with($notification);
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();

        return response()->json();
    }
}
