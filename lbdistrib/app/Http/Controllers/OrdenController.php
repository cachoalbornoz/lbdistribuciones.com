<?php

namespace App\Http\Controllers;

use App\Models\Pago,
    App\Models\DetallePago,
    App\Models\Compra,
    App\Models\Proveedor,
    App\Models\TipoComprobante,
    App\Models\Vendedor,
    App\Models\TipoFormapago,
    App\Models\MovProveedor;

use Illuminate\Http\Request;
use App\Http\Requests\PagoRequest;

use Carbon\Carbon;

class OrdenController extends Controller
{

    public function index(){
        $pagos = Pago::where('tipocomprobante', 17)->orderBy('fecha', 'DESC')->orderBy('id', 'ASC')->get();
        return view('admin.ordenpago.index', compact('pagos'));
    }

    public function ordenPagoProveedor($id){
        $pagos      = Pago::Where('proveedor', $id)->where('tipocomprobante', 17)
            ->orderBy('fecha', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $proveedor  = Proveedor::find($id);
        return view('admin.ordenpago.index', compact('id', 'pagos', 'proveedor'));
    }

    public function create($id)
    {
        $Pago           = Pago::orderBy('nro', 'desc')->first();
        $nroPago        = isset($Pago) ? $Pago->nro + 1 : 1; 
        
        if($id){
            $proveedor   = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
            ->where('id', $id)
            ->pluck('nombreCompleto', 'id');
        }else{
            $proveedor = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
            ->orderBy('nombreEmpresa','ASC')
            ->pluck('nombreCompleto', 'id');
        }        

        $tipocomprobante= TipoComprobante::orWhere('id', '=' ,17)->orderBy('id','DESC')->pluck('comprobante', 'id');
        return view('admin.ordenpago.create', compact('id', 'proveedor', 'tipocomprobante', 'nroPago'));
    }

    public function store(PagoRequest $request)
    {
        $pago = new Pago($request->all());
        $pago->save();

        return redirect()->route('detalleordenpago.index', ['id' => $pago->id]);
    }

    public function destroy(Request $request)
    {
        $pago      = Pago::find($request->id);
        $proveedor = $pago->proveedor;

        // Quitar autorización 
        $actualizacion = ['orden' => null, 'autorizada'=>null, 'fechaautorizacion' => null];
        Compra::Where('orden', '=', $pago->nro)->update($actualizacion);

        $pago->delete();

        $pagos      = Pago::Where('proveedor', $proveedor)->where('tipocomprobante', 17)
            ->orderBy('fecha', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $vistaOrden= view('admin.ordenpago.detalle', compact('pagos', 'proveedor'))->render();
        return response()->json($vistaOrden);        
    }

    public function anular($id)
    {
        $pago      = Pago::find($id);
        $proveedor = $pago->proveedor;

        // Quitar autorización 
        $actualizacion = ['orden' => null, 'autorizada'=>null, 'fechaautorizacion' => null];
        Compra::Where('orden', '=', $pago->nro)->update($actualizacion);

        $pago->delete();

        return redirect()->route('ordenpago.pagoProveedor', $proveedor);
    }


}