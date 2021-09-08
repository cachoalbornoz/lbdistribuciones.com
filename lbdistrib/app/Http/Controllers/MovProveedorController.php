<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MovProveedor,
    App\Models\Compra,
    App\Models\Pago,
	App\Models\Proveedor;

class MovProveedorController extends Controller
{
    public function index($id){
    	$proveedor 		= Proveedor::where('id',$id)->first();
        $movproveedores = MovProveedor::where('proveedor', $id)
            ->orderBy('fecha', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.movproveedores.index', compact('proveedor', 'movproveedores'));
    }

    public function deuda($id){ 

        $proveedor      = Proveedor::where('id', $id)->first();

        $compras        = Compra::where('proveedor', '=', $id)->where('tipocomprobante', '=', 2)->whereNull('pagada')->orderBy('fecha', 'ASC')->get();

        $tcompra        = Compra::where('proveedor', '=', $id)->where('tipocomprobante', '=', 2)->whereNull('pagada')->sum('total');
        $ncredito       = Compra::where('proveedor', '=', $id)->where('tipocomprobante', '=', 8)->whereNull('pagada')->sum('total');
        $ndebito        = Pago::where('proveedor', '=', $id)->where('tipocomprobante', '=', 9)->sum('total');
        $cobro          = Pago::where('proveedor', '=', $id)->where('tipocomprobante', '=', 16)->sum('total');

        $totalacobrar   = $tcompra-$ncredito-$cobro+$ndebito;

        return  view('admin.movproveedores.deuda', compact('proveedor', 'compras', 'totalacobrar', 'tcompra', 'ncredito', 'cobro', 'ndebito'));
    }
  
    public function destroy(Request $request)
    {
        $movproveedor = MovProveedor::find($request->id);
        $Proveedor    = $movproveedor->Proveedor;
        $movproveedor->delete();

        ////
        // ACTUALIZO EL SALDO
        $nuevoSaldo = 0;
        $movimientos= MovProveedor::where('proveedor', $Proveedor->id)->orderBy('fecha', 'ASC')->get();
        foreach ($movimientos as $movimiento) {
            $movimiento->saldo  = $nuevoSaldo + $movimiento->debe - $movimiento->haber;
            $nuevoSaldo         = $movimiento->saldo;
            $movimiento->save();
        }
        $Proveedor->saldo = abs($nuevoSaldo);
        $Proveedor->save();

        $movproveedores = MovProveedor::where('proveedor', $Proveedor->id)
            ->orderBy('fecha', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        $vistaMovimientos= view('admin.movproveedores.detalle', compact('movproveedores'))->render();
        return response()->json($vistaMovimientos);   
    }

}
