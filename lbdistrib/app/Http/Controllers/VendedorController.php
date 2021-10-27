<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User,
    Caffeinated\Shinobi\Models\Role,
    App\Models\Marca;

use Image;

use Yajra\DataTables\Facades\DataTables;

class VendedorController extends Controller
{

    public function index()
    {
        $users = User::all();
        $arrUser= array();
        foreach($users as $user){
            $user->isRole('vendedor')?array_push($arrUser,$user->id):null;
        }
        $vendedores = User::whereIn('id',$arrUser)->get();

        return view('admin.vendedores.index', compact('vendedores'));
    }

    public function asociar(Request $request){

        $id = $request->id;
        $vendedor   = User::find($id);
        $marcas     = Marca::orderBy('nombre', 'ASC')->get();

        return view('admin.vendedores.asociar', compact('vendedor', 'marcas'));
    }

    public function update(Request $request){

        $user = User::find($request->id);

        //actualizar roles
        $user->marcas()->sync($request->get('marcas'));

        $notification = array(
            'message' => 'Vendedor y marcas se han actualizado !',
            'alert-type' => 'success'
        );

        return redirect()->route('vendedor.index')->with($notification);
    }

}
