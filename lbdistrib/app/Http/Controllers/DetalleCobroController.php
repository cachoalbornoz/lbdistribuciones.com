<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cobro,
    App\Models\Contacto,
    App\Models\MovContacto,
    App\Models\Banco,
    App\Models\MovCheque,
    App\Models\DetalleCobro,
    App\Models\TipoPago,
    App\Models\Venta;


class DetalleCobroController extends Controller
{

    public function index($id)
    {
        $cobro          = Cobro::where('id', $id)->first();
        $detallecobro   = DetalleCobro::where('cobro', '=', $id)->where('tipopago', '=', 1)->orderBy('id', 'ASC')->get();
        $totalEfectivo  = DetalleCobro::where('cobro', '=', $id)->where('tipopago', '=', 1)->sum('importe');
        $detalleTrans       = DetalleCobro::where('cobro', '=', $id)->where('tipopago', '=', 3)->orderBy('id', 'ASC')->get();
        $totalTransferencia = DetalleCobro::where('cobro', '=', $id)->where('tipopago', '=', 3)->sum('importe');
        $requestArray   = [9, 16];
        $detallecheque  = MovCheque::where('idcomprobante', $id)->whereIn('tipocomprobante', $requestArray)->orderBy('id', 'ASC')->get();
        $totalCheque    = MovCheque::where('idcomprobante', $id)->whereIn('tipocomprobante', $requestArray)->sum('importe');
        $banco          = Banco::orderBy('nombre', 'ASC')->pluck('nombre', 'id');

        $contacto       = $cobro->contacto;
        $remanente      = $cobro->Contacto->remanente;
        
        $tipopago       = TipoPago::orderBy('id', 'ASC')->pluck('tipopago', 'id');
        
        $ventas         = Venta::where('contacto', '=', $cobro->contacto)->whereNull('pagada')->orWhere('recibo', '=', $cobro->nro)->orderBy('id', 'DESC')->get();
        $ventasp        = Venta::where('contacto', '=', $cobro->contacto)->where('tipocomprobante', '=', 2)->Where('recibo', '=', $cobro->nro)->sum('total');
        $ncredito       = Venta::where('contacto', '=', $cobro->contacto)->where('tipocomprobante', '=', 8)->Where('recibo', '=', $cobro->nro)->sum('total');
        $ventaspagadas  = $ventasp - $ncredito;
        
        $totalCobrado   = number_format($ventaspagadas,2);

        return view('admin.detallecobros.index', 
            compact('cobro', 'totalEfectivo', 'totalCheque', 'totalTransferencia',
            'detallecobro', 'detallecheque', 'detalleTrans', 'tipopago', 'banco', 'ventas', 'totalCobrado', 'ventaspagadas', 'remanente'));
    }

    public function cerrar(Request $request){

        $cobro          = Cobro::find($request->id);
        $contacto       = $cobro->Contacto;
        $tipoComprobante= $cobro->tipocomprobante;
        $cobro->total   = $request->totalCobrado;
        $cobro->save();

        $movi = MovContacto::where('idcomprobante', '=', $request->id)->where('tipocomprobante', '=', $tipoComprobante)->first();

        // Actualizo el movimiento en la Cta Cte
        if($tipoComprobante == 9) {                 // NOTA DEBITO
            $movi->debe = $request->totalCobrado;
        }else{                                      // RECIBO
            $movi->haber= $request->totalCobrado;
        }            
        $movi->save();

        // ACTUALIZO LOS SALDOS
        $nuevoSaldo = 0;
        $movimientos= MovContacto::where('contacto', $cobro->contacto)->orderBy('fecha', 'ASC')->get();

        foreach ($movimientos as $movimiento) {
            $movimiento->saldo  = $nuevoSaldo + $movimiento->debe - $movimiento->haber;
            $nuevoSaldo         = $movimiento->saldo;
            $movimiento->save();
        }

        // Actualizo el remanente y saldo, si corresponde
        if($nuevoSaldo<0){
            $contacto->saldo = 0;
            $contacto->remanente = abs($nuevoSaldo);    
        }else{
            $contacto->saldo = $nuevoSaldo;
        }

        $contacto->save();
        
        return response()->json(['movi' => $movi]);
    }

    public function imputacion(Request $request)
    {
        if ($request->ajax()) {

            $cobro          = Cobro::find($request->cobro);
            $contacto       = Contacto::find($cobro->contacto);
            $remanente      = $contacto->remanente;
            $venta          = Venta::find($request->factura);

            if ($venta->pagada == 1) {

                $venta->recibo      = null;
                $venta->pagada      = null;
                $venta->fechapago   = null;

            } else {

                $venta->recibo      = $cobro->nro;
                $venta->pagada      = 1;
                $venta->fechapago   = $cobro->fecha;
            }

            $venta->save();

            $ventas         = Venta::where('contacto', '=', $cobro->contacto)->whereNull('pagada')->orWhere('recibo', '=', $cobro->nro)->orderBy('id', 'DESC')->get();
            $ventasp        = Venta::where('contacto', '=', $cobro->contacto)->where('tipocomprobante', '=', 2)->Where('recibo', '=', $cobro->nro)->sum('total');
            $ncredito       = Venta::where('contacto', '=', $cobro->contacto)->where('tipocomprobante', '=', 8)->Where('recibo', '=', $cobro->nro)->sum('total');
            $ventaspagadas  = $ventasp - $ncredito;
            
            $totalCobrado   = number_format($ventaspagadas,2); 

            $imputacion     = view('admin.detallecobros.detalleimputacion', compact('ventas', 'totalCobrado'))->render();

            return response()->json(['imputacion' => $imputacion, 'totalCobrado' => $totalCobrado]);
        }
    }

    public function show($id)
    {
        $cobro              = Cobro::where('id', $id)->first();
        $contacto           = $cobro->contacto;
        $detallecobro       = DetalleCobro::where('cobro', '=', $id)->where('tipopago', '=', 1)->orderBy('id', 'ASC')->get();
        $totalEfectivo      = DetalleCobro::where('cobro', '=', $id)->where('tipopago', '=', 1)->sum('importe');
        $detalleTrans       = DetalleCobro::where('cobro', '=', $id)->where('tipopago', '=', 3)->orderBy('id', 'ASC')->get();
        $totalTransferencia = DetalleCobro::where('cobro', '=', $id)->where('tipopago', '=', 3)->sum('importe');
        $requestArray       = [9, 16];
        $detallecheque      = MovCheque::where('idcomprobante', $id)->whereIn('tipocomprobante', $requestArray)->orderBy('id', 'ASC')->get();
        $totalCheque        = MovCheque::where('idcomprobante', $id)->whereIn('tipocomprobante', $requestArray)->sum('importe');

        $ventas             = Venta::where('contacto', $contacto)->where('recibo', $cobro->nro)->orderBy('fecha', 'DESC')->get();

        return view('admin.detallecobros.show', 
            compact('cobro', 'detallecobro', 'detallecheque', 'detalleTrans', 'ventas'));
    }

    // INGRESO DE EFECTIVO / TRANSFERENCIA
    public function insert(Request $request)
    {
        if ($request->ajax()) {

            // Elimino si antes se habia cargado un pago 
            DetalleCobro::where('cobro', '=', $request->cobro)->where('tipopago', '=', $request->tipopago)->delete();

            // Ingreso un movimiento al tipo de pago
            $detalle = new DetalleCobro($request->all());
            if ($request->recargo < 1) {
                $porcentaje = (1 - $request->recargo);
            } else {
                $porcentaje = $request->recargo;
            }

            $detalle->subtotal      = ($request->importe * $porcentaje);
            $detalle->montorecargo  = $request->importe - $detalle->subtotal;
            $detalle->save();

            $detallecobro   = DetalleCobro::where('cobro', '=', $request->cobro)->where('tipopago', '=', 1)->orderBy('id', 'ASC')->get();
            $detalleTrans   = DetalleCobro::where('cobro', '=', $request->cobro)->where('tipopago', '=', 3)->orderBy('id', 'ASC')->get();

            $vistaEfectivo       = view('admin.detallecobros.detalleefectivo', compact('detallecobro', 'detalleTrans'))->render();

            return response()->json(['vistaEfectivo' => $vistaEfectivo]);
        }
    }

    public function destroy(Request $request)
    {
        $detalle = DetalleCobro::find($request->id);
        $detalle->delete();

        $detallecobro   = DetalleCobro::where('cobro', '=', $request->cobro)->where('tipopago', '=', 1)->orderBy('id', 'ASC')->get();
        $detalleTrans   = DetalleCobro::where('cobro', '=', $request->cobro)->where('tipopago', '=', 3)->orderBy('id', 'ASC')->get();
        $totalCobrado   = $request->totalCobrado;
        $detallecheque  = MovCheque::where('idcomprobante', $request->cobro)->where('tipocomprobante', 16)->orderBy('id', 'ASC')->get();

        $efectivo       = view('admin.detallecobros.detalleefectivo', compact('detallecobro', 'detalleTrans'))->render();

        return response()->json(['efectivo' => $efectivo]);
    }

    // INGRESO DE CHEQUES
    public function insertc(Request $request)
    {
        if ($request->ajax()) {

            $cheque        = new MovCheque($request->all());
            $cheque->save();

            $detallecobro   = DetalleCobro::where('cobro', $request->idcomprobante)->orderBy('id', 'ASC')->get();
            $totalCobrado   = $request->totalCobrado;

            // WHERE IN
            $requestArray   = [9, 16];
            $detallecheque  = MovCheque::where('idcomprobante', $request->idcomprobante)->whereIn('tipocomprobante', $requestArray)->orderBy('id', 'ASC')->get();

            $cheque         = view('admin.detallecobros.detallecheque', compact('detallecheque'))->render();

            return response()->json(['cheque' => $cheque]);
        }
    }

    public function destroyc(Request $request)
    {
        $detalle = MovCheque::find($request->id);
        $detalle->delete();

        $detallecheque  = MovCheque::where('idcomprobante', $request->idcomprobante)->where('tipocomprobante', 16)->orderBy('id', 'ASC')->get();
        $totalCobrado   = $request->totalCobrado;
        $detallecobro   = DetalleCobro::where('cobro', $request->idcomprobante)->orderBy('id', 'ASC')->get();

        $cheque         = view('admin.detallecobros.detallecheque', compact('detallecheque'))->render();

        return response()->json(['cheque' => $cheque]);
    }

    public function asociarVenta(Request $request)
    {
        if ($request->ajax()) {

            $idcobro    = $request->idcobro;
            $idventa    = $request->idventa;
            $accion     = $request->accion;

            $cobro      = Cobro::findOrFail($idcobro);
            $venta      = Venta::findOrFail($idventa);

            if ($accion == 1) {   // agregar
                $cobro->ventas()->attach($idventa);
            } else {              // quitar
                $cobro->ventas()->detach($idventa);
            }

            $cobro          = Cobro::where('id', $idcobro)->first();
            $detallecobro   = DetalleCobro::where('cobro', $idcobro)->orderBy('id', 'ASC')->get();
            $detallecheque  = MovCheque::where('idcomprobante', $idcobro)->where('tipocomprobante', 16)->orderBy('id', 'ASC')->get();
            $tipopago       = TipoPago::orderBy('id', 'ASC')->pluck('tipopago', 'id');
            $banco          = Banco::orderBy('nombre', 'ASC')->pluck('nombre', 'id');

            $contacto       = $cobro->contacto;

            $ventas         = Venta::where('contacto', $contacto)->orderBy('fecha', 'DESC')->get();

            $view = view('admin.detallecobros.index', compact('cobro', 'detallecobro', 'tipopago', 'banco', 'detallecheque', 'ventas'))
                ->renderSections()['detalle'];

            return response()->json($view);
        }
    }
}