<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Marca,
    App\Models\Producto,
    App\Models\Rubro;

use Carbon\Carbon;

class MarcaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:marca.index')->only('index');
        $this->middleware('permission:marca.create')->only(['create', 'store']);
        $this->middleware('permission:marca.edit')->only(['edit', 'update']);
        $this->middleware('permission:marca.destroy')->only('destroy');
    }


    public function index(){

        $marcas     = Marca::orderBy('nombre', 'ASC')->get();

        return view('admin.marcas.index', compact('marcas'));
    }


    public function create()
    {
        return view('admin.marcas.create');
    }


    public function store(Request $request)
    {
        // GUARDAR LA IMAGEN
        $name = null;
        if($request->file()){

            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $path = public_path().'/images/upload/marcas/';
            $file->move($path, $name);
        }

        $marca = new Marca($request->all());
        $marca->image = $name;
        $marca->save();

        $notification = array(
            'message' => $marca->nombre .' se ha guardado correctamente !',
            'alert-type' => 'success');

        return redirect()->route('marca.index')->with($notification);
    }


    public function edit($id)
    {
        $marca  = Marca::find($id);

        return view('admin.marcas.edit', compact('marca'));
    }


    public function update(Request $request, $id)
    {
        $marca   = Marca::find($id);

        if($request->file()){

            $path   = public_path().'/images/upload/marcas/';

            if(\File::exists($path.$marca->image)){

               \File::delete($path.$marca->image);
            }

            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $file->move($path, $name);

        }else{

            $name = $marca->image;
        }

        $marca->fill($request->all());
        $marca->image = $name;
        $marca->save();

        $notification = array(
            'message' => $marca->nombre .' se ha guardado correctamente !',
            'alert-type' => 'warning');

        return redirect()->route('marca.index')->with($notification);
    }

    public function destroy(Request $request)
    {
        $marca   = Marca::find($request->id);

        $path    = public_path().'/images/upload/marcas/';

        if(\File::exists($path.$marca->image)){

           \File::delete($path.$marca->image);
        }

        $marca->delete();

        return response()->json();
    }

}
