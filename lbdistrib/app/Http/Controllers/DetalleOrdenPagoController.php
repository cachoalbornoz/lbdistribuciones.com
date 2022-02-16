<?php

namespace App\Http\Controllers;

use App\Models\Banco;

use App\Models\Compra;
use App\Models\DetallePago;
use App\Models\MovCheque;
use App\Models\Pago;
use App\Models\TipoPago;
use Illuminate\Http\Request;

class DetalleOrdenPagoController extends Controller
{
    public function index($id)
    {
        $pago               = Pago::where('id', $id)->first();
        $detallepago        = DetallePago::where('pago', '=', $id)->where('tipopago', '=', 1)->orderBy('id', 'ASC')->get();
        $totalEfectivo      = DetallePago::where('pago', '=', $id)->where('tipopago', '=', 1)->sum('importe');
        $detalleTrans       = DetallePago::where('pago', '=', $id)->where('tipopago', '=', 3)->orderBy('id', 'ASC')->get();
        $totalTransferencia = DetallePago::where('pago', '=', $id)->where('tipopago', '=', 3)->sum('importe');

        $cheques       = MovCheque::whereNull('pagado')->orderBy('id', 'DESC')->get();
        $detallecheque = MovCheque::where('recibo', '=', $pago->nro)->orderBy('id', 'ASC')->get();
        $totalCheque   = MovCheque::where('recibo', '=', $pago->nro)->sum('importe');

        $proveedor = $pago->proveedor;
        $remanente = $pago->Proveedor->remanente;

        $tipopago = TipoPago::orderBy('id', 'ASC')->pluck('tipopago', 'id');

        $compras = Compra::where('proveedor', '=', $pago->proveedor)
            ->WhereNull('autorizada')
            ->orWhere('orden', '=', $pago->nro)
            ->orderBy('id', 'DESC')->get();

        $comprasp        = Compra::where('proveedor', '=', $pago->proveedor)->where('tipocomprobante', '=', 2)->Where('orden', '=', $pago->nro)->sum('total');
        $ncredito        = Compra::where('proveedor', '=', $pago->proveedor)->where('tipocomprobante', '=', 8)->Where('orden', '=', $pago->nro)->sum('total');
        $compraspagadas  = $comprasp - $ncredito;
        $totalAutorizado = $compraspagadas;

        return view(
            'admin.detalleordenpagos.index',
            compact(
                'pago',
                'totalEfectivo',
                'totalCheque',
                'totalTransferencia',
                'cheques',
                'detallepago',
                'detallecheque',
                'detalleTrans',
                'tipopago',
                'compras',
                'totalAutorizado',
                'compraspagadas',
                'remanente'
            )
        );
    }

    public function autorizacion(Request $request)
    {
        if ($request->ajax()) {
            $pago   = Pago::find($request->pago);
            $compra = Compra::find($request->compraId);
            if ($compra->autorizada == 1) {
                $compra->orden             = null;
                $compra->autorizada        = null;
                $compra->fechaautorizacion = null;
            } else {
                $compra->orden             = $pago->nro;
                $compra->autorizada        = 1;
                $compra->fechaautorizacion = $pago->fecha;
            }
            $compra->save();

            $compras         = Compra::where('proveedor', '=', $pago->proveedor)->whereNull('autorizada')->orWhere('orden', '=', $pago->nro)->orderBy('id', 'DESC')->get();
            $totalAutorizado = Compra::where('proveedor', '=', $pago->proveedor)->Where('orden', '=', $pago->nro)->Where('autorizada', '=', 1)->sum('total');
            $imputacion      = view('admin.detalleordenpagos.detalleimputacion', compact('compras', 'totalAutorizado'))->render();

            return response()->json(['imputacion' => $imputacion, 'autorizado' => $totalAutorizado]);
        }
    }

    public function show($id)
    {
        $pago          = Pago::where('id', $id)->first();
        $detallepago   = DetallePago::where('pago', $id)->orderBy('id', 'ASC')->get();
        $requestArray  = [17];
        $detallecheque = MovCheque::where('idcomprobante', $id)->whereIn('tipocomprobante', $requestArray)->orderBy('id', 'ASC')->get();
        $banco         = Banco::orderBy('nombre', 'ASC')->pluck('nombre', 'id');

        $proveedor    = $pago->proveedor;
        $totalCobrado = $pago->total;

        $pagos = Pago::where('proveedor', $proveedor)->where('orden', $pago->nro)->orderBy('fecha', 'DESC')->get();

        return view('admin.detallepagos.show', compact('pago', 'detallepago', 'banco', 'detallecheque', 'pagos', 'totalCobrado'));
    }

    public function insert(Request $request)
    {
        $detalle = new DetallePago($request->all());

        if ($request->recargo < 1) {
            $porcentaje = (1 - $request->recargo);
        } else {
            $porcentaje = $request->recargo;
        }

        $detalle->subtotal     = ($request->importe * $porcentaje);
        $detalle->montorecargo = $request->importe - $detalle->subtotal;

        $detalle->save();

        return response()->json($detalle);
    }

    public function destroy(Request $request)
    {
        $detalle = DetallePago::find($request->id);
        $detalle->delete();

        return response()->json();
    }
}
