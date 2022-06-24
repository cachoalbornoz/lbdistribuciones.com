<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User,
    Caffeinated\Shinobi\Models\Role,
    App\Models\Marca;
use Illuminate\Http\JsonResponse;
use Image;

use Yajra\DataTables\Facades\DataTables;

class VendedorController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $users = User::all();
            $arrUser= array();
            foreach($users as $user){
                $user->isRole('vendedor')?array_push($arrUser,$user->id):null;
            }
            $vendedor = User::whereIn('id',$arrUser)->get();

            if ($vendedor) {
                return Datatables::of($vendedor)
               
                ->addColumn('editar', function ($vendedor) {
                    return "<a onclick='editVendedor(".$vendedor.")'> <i class='fa fa-pencil'></i> </a>";
                })
                ->addColumn('asociar', function ($vendedor) {
                    return '<a href="'. route('vendedor.asociar', $vendedor->id).'"> Asociar marcas </a>';
                })
                ->rawColumns(['id', 'editar', 'asociar'])
                ->make(true);
            }
        }
        return view('admin.vendedores.index');
    }

    public function asociar(Request $request){

        $vendedor   = User::find($request->id);
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

    public function actualizar(Request $request)
    {	
        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nombre del vendedor es necesario',
        ]);

        User::find($request->id)->update($request->all());
        
        return new JsonResponse([
            'type' => 'success',
            'msg' => 'Actualizado ',
        ]);
         
    }
}
