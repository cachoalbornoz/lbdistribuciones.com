<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pago, 
    App\Models\DetallePago, 
    App\Models\Compra,
    App\Models\Proveedor, 
    App\Models\MovProveedor,
    App\Models\MovCheque,
    App\Models\Banco,
    App\Models\TipoPago;


class DetallePagoController extends Controller
{
    
    public function index($id)
    {
        $pago               = Pago::where('id', $id)->first();
        $detallepago        = DetallePago::where('pago', '=', $id)->where('tipopago', '=', 1)->orderBy('id', 'ASC')->get();
        $totalEfectivo      = DetallePago::where('pago', '=', $id)->where('tipopago', '=', 1)->sum('importe');
        $detalleTrans       = DetallePago::where('pago', '=', $id)->where('tipopago', '=', 3)->orderBy('id', 'ASC')->get();
        $totalTransferencia = DetallePago::where('pago', '=', $id)->where('tipopago', '=', 3)->sum('importe');

        $cheques        = MovCheque::whereNull('pagado')->orderBy('id', 'DESC')->get();
        $detallecheque  = MovCheque::where('recibo', '=', $pago->nro)->orderBy('id', 'ASC')->get();
        $totalCheque    = MovCheque::where('recibo', '=', $pago->nro)->sum('importe');
        
        $proveedor      = $pago->proveedor;   
        $remanente      = $pago->Proveedor->remanente;

        $tipopago       = TipoPago::orderBy('id', 'ASC')->pluck('tipopago', 'id');
        
        $compras        = Compra::where('autorizada', '=', 1)
            ->where('proveedor', '=', $pago->proveedor)
            ->Where('orden', '=', $pago->nro)
            ->orderBy('id', 'DESC')->get();

        $comprasp       = Compra::where('proveedor', '=', $pago->proveedor)
            ->where('tipocomprobante', '=', 2)
            ->Where('recibo', '=', $pago->nro)->where('pagada', '=', 1)->sum('total');

        $ncredito       = Compra::where('proveedor', '=', $pago->proveedor)
            ->where('tipocomprobante', '=', 8)
            ->Where('recibo', '=', $pago->nro)->where('pagada', '=', 1)->sum('total');
        $compraspagadas = $comprasp - $ncredito;
        $totalPagado    = $compraspagadas; 

        return view('admin.detallepagos.index', 
            compact('pago', 'totalEfectivo', 'totalCheque', 'totalTransferencia', 'cheques',
            'detallepago', 'detallecheque', 'detalleTrans', 'tipopago', 'compras', 'totalPagado', 'compraspagadas', 'remanente'));
        
    }

    public function autorizacion(Request $request)
    {
        if ($request->ajax()) {

            $pago       = Pago::find($request->pago);
            $proveedor  = Proveedor::find($pago->proveedor);            
            $remanente  = $proveedor->remanente;
            $compra     = Compra::find($request->compraId);

            if ($compra->pagada == 1) {
                $compra->recibo      = null;
                $compra->pagada      = null;
                $compra->fechapago   = null;

            } else {                
                $compra->recibo      = $pago->nro;
                $compra->pagada      = 1;
                $compra->fechapago   = $pago->fecha;
            }

            $compra->save();

            $compras        = Compra::where('proveedor', '=', $pago->proveedor)->where('autorizada', '=', 1)->Where('orden', '=', $pago->nro)->orderBy('id', 'DESC')->get();
            $comprasp       = Compra::where('proveedor', '=', $pago->proveedor)->where('tipocomprobante', '=', 2)->Where('recibo', '=', $pago->nro)->sum('total');
            $ncredito       = Compra::where('proveedor', '=', $pago->proveedor)->where('tipocomprobante', '=', 8)->Where('recibo', '=', $pago->nro)->sum('total');
            $compraspagadas = $comprasp - $ncredito;            
            $totalPagado    = $compraspagadas - $remanente; 

            $imputacion     = view('admin.detallepagos.detalleimputacion', compact('compras', 'totalPagado'))->render();

            return response()->json(['imputacion' => $imputacion, 'totalPagado' => $totalPagado]);
        }
    }

    public function cerrar(Request $request){

        $pago           = Pago::find($request->id);
        $proveedor      = $pago->Proveedor;

        $tipoComprobante= $pago->tipocomprobante;
        $pago->tipocomprobante = ($pago->tipocomprobante == 17)?16:$pago->tipocomprobante;
        $pago->cerrado  = 1;
        $pago->total    = $request->totalPagado;
        $pago->save();

        $movi = MovProveedor::where('idcomprobante', '=', $request->id)->where('tipocomprobante', '=', $tipoComprobante)->first();

        // Actualizo el movimiento en la Cta Cte
        if($tipoComprobante == 9) {                 // NOTA DEBITO
            $movi->debe = $request->totalPagado;
        }else{                                      // RECIBO
            $movi->concepto = 'RECIBO';
            $movi->haber= $request->totalPagado;
        }            
        $movi->save();

        // ACTUALIZO LOS SALDOS
        $nuevoSaldo = 0;
        $movimientos= MovProveedor::where('proveedor', $pago->proveedor)->orderBy('fecha', 'ASC')->get();

        foreach ($movimientos as $movimiento) {
            $movimiento->saldo  = $nuevoSaldo + $movimiento->debe - $movimiento->haber;
            $nuevoSaldo         = $movimiento->saldo;
            $movimiento->save();
        }

        // Actualizo el remanente, si corresponde
        if($request->saldo > 0){
            if($proveedor->remanente > 0 ){
                $proveedor->remanente =  $request->saldo;
            }else{
                $proveedor->remanente =  $proveedor->remanente + $request->saldo;
            }
        }else{
            $proveedor->remanente =  0;    
        }

        // Actualizar el saldo 
        $proveedor->saldo = $nuevoSaldo;
        $proveedor->save();
        
        return response()->json(['movi' => $movi]);
    }

    // INGRESO DE EFECTIVO / TRANSFERENCIA
    public function insert(Request $request)
    {
        if ($request->ajax()) {

            // Elimino si antes se habia cargado un pago 
            DetallePago::where('pago', '=', $request->pago)->where('tipopago', '=', $request->tipopago)->delete();

            // Ingreso un movimiento al tipo de pago
            $detalle = new DetallePago($request->all());
            if ($request->recargo < 1) {
                $porcentaje = (1 - $request->recargo);
            } else {
                $porcentaje = $request->recargo;
            }

            $detalle->subtotal      = ($request->importe * $porcentaje);
            $detalle->montorecargo  = $request->importe - $detalle->subtotal;
            $detalle->save();

            $pago           = Pago::find($request->pago);
            $detallepago    = DetallePago::where('pago', '=', $request->pago)->where('tipopago', '=', 1)->orderBy('id', 'ASC')->get();
            $detalleTrans   = DetallePago::where('pago', '=', $request->pago)->where('tipopago', '=', 3)->orderBy('id', 'ASC')->get();

            $vistaEfectivo  = view('admin.detallepagos.detalleefectivo', compact('detallepago', 'detalleTrans'))->render();

            return response()->json(['vistaEfectivo' => $vistaEfectivo]);
        }
    }

    // ELIMINAR EFECTIVO / TRANSFERENCIA
    public function destroy(Request $request)
    {
        $detalle = DetallePago::find($request->id);
        $detalle->delete();

        $detallepago    = DetallePago::where('pago', '=', $request->pago)->where('tipopago', '=', 1)->orderBy('id', 'ASC')->get();
        $detalleTrans   = DetallePago::where('pago', '=', $request->pago)->where('tipopago', '=', 3)->orderBy('id', 'ASC')->get();

        $pago           = Pago::find($request->pago);
        $vistaEfectivo  = view('admin.detallepagos.detalleefectivo', compact('detallepago', 'detalleTrans'))->render();
        
        return response()->json(['vistaEfectivo' => $vistaEfectivo]);
    }

    // INGRESO DE CHEQUES
    public function insertc(Request $request) {
        if ($request->ajax()) {

            $pago       = Pago::find($request->pago);
            $cheque     = MovCheque::find($request->chequeId);

            if ($cheque->pagado == 1) {
                $cheque->recibo      = null;
                $cheque->pagado      = null;
                $cheque->fechapago   = null;
            } else {                
                $cheque->recibo      = $pago->nro;
                $cheque->pagado      = 1;
                $cheque->fechapago   = $pago->fecha;
            }
            $cheque->save();

            $cheques        = MovCheque::whereNull('pagado')->orderBy('id', 'DESC')->get();
            $detallecheque  = MovCheque::where('recibo', '=', $pago->nro)->orderBy('id', 'ASC')->get();            
            $totalCheque    = MovCheque::where('recibo', '=', $pago->nro)->sum('importe');
            $vistaCheques   = view('admin.detallepagos.detallecheque', compact('cheques', 'detallecheque'))->render();

            return response()->json(['vistaCheques' => $vistaCheques, 'totalCheque' =>$totalCheque]);
        }
    }

    public function show($id)
    {
        $pago   = Pago::where('id', $id)->first();
        $pagos  = DetallePago::where('pago', $id)->orderBy('id', 'ASC')->get();
        $cheques= MovCheque::where('recibo', '=', $pago->nro)->orderBy('id', 'ASC')->get();

        return view('admin.detallepagos.show', compact('pago', 'pagos', 'cheques'));
    }

}
