<?php

namespace App\Http\Controllers;

use App\Models\Proveedor,
    App\Models\MovProveedor,
    App\Models\Ciudad,
    App\Models\TipoResponsable;

use Illuminate\Http\Request;
use App\Http\Requests\ProveedorRequest;


class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:proveedor.index')->only('index');
        $this->middleware('permission:proveedor.create')->only(['create', 'store']);
        $this->middleware('permission:proveedor.edit')->only(['edit', 'update']);
        $this->middleware('permission:proveedor.destroy')->only('destroy');
    }

    public function index(){

        $proveedores = Proveedor::orderBy('nombreempresa', 'ASC')->get();
        return view('admin.proveedores.index', compact('proveedores'));
    }


    public function create(){

        $ciudad         = Ciudad::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $tiporesponsable= TipoResponsable::orderBy('condicion', 'ASC')->pluck('condicion', 'id');

        return view('admin.proveedores.create', compact('ciudad', 'tiporesponsable'));
    }

    public function store(ProveedorRequest $request){

        $proveedor   = new Proveedor($request->all());
        $proveedor->save();

        $movimiento = new MovProveedor();

        $movimiento->proveedor      = $proveedor->id;
        $movimiento->tipocomprobante= 10;
        $movimiento->idcomprobante  = 0;
        $movimiento->nro            = 0;
        $movimiento->fecha          = date('Y-m-d',time());
        $movimiento->concepto       = 'REGISTRO PROVEEDOR';
        $movimiento->debe           = 0;
        $movimiento->haber          = 0;
        $movimiento->saldo          = $proveedor->saldo;
        $movimiento->save();

        $notification = array(
            'message' => $proveedor->nombreempresa .', ('.$proveedor->apellido.', '.$proveedor->nombres.') se ha guardado correctamente !',
            'alert-type' => 'success');

        return redirect()->route('proveedor.index')->with($notification);
    }


    public function edit($id){

        $proveedor      = Proveedor::find($id);
        $ciudad         = Ciudad::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $tiporesponsable= TipoResponsable::orderBy('condicion', 'ASC')->pluck('condicion', 'id');

        return view('admin.proveedores.edit', compact('proveedor', 'ciudad', 'tiporesponsable'));
    }


    public function update(Request $request, $id){

        $proveedor = Proveedor::find($id);
        $proveedor->fill($request->all());
        $proveedor->save();

        $notification = array(
            'message' => $proveedor->nombreempresa .' se ha guardado correctamente !',
            'alert-type' => 'success');

        return redirect()->route('proveedor.edit', $id)->with($notification);
    }

    public function destroy(Request $request){

        Proveedor::where("id", $request->id)->delete();

        return response()->json();
    }
}