<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;

class DetalleCompraController extends Controller
{

    public function index($id){
        $compra         = Compra::where('id', $id)->first();
        $detallecompra  = DetalleCompra::where('compra', $id)->orderBy('id', 'ASC')->get();
        $producto       = Producto::selectRaw('id, CONCAT(nombre," | $ ", preciolista) as infoProducto')->orderBy('nombre', 'ASC')->pluck('infoProducto', 'id');

        return view('admin.detallecompras.index', compact('compra', 'detallecompra', 'producto'));
    }

    public function show($id)
    {
        $compra          = Compra::where('id', $id)->first();
        $detallecompra   = DetalleCompra::where('compra', $id)->orderBy('id', 'ASC')->get() ;

        return view('admin.detallecompras.show', compact('compra', 'detallecompra'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insert(Request $request)
    {
        $detalle                    = new DetalleCompra();

        $detalle->producto          = $request->producto;
        $detalle->compra            = $request->compra;
        $detalle->precio            = $request->precio;
        $detalle->cantidad          = $request->cantidad;
        $detalle->iva               = $request->iva;

        $subtotal                   = $request->precio * $request->cantidad;
        $detalle->descuento         = $request->descuento;
        $detalle->descuento1        = $request->descuento1;

        $detalle->montodesc         = ($request->descuento > 0) ? $subtotal * ($request->descuento / 100) : 0;
        $detalle->montodesc1        = ($request->descuento1 > 0) ? $subtotal * ($request->descuento1 / 100) : 0;
        $detalle->montoiva          = ($request->iva > 0) ? ($subtotal - $detalle->montodesc - $detalle->montodesc1) * ($request->iva / 100) : 0;

        $detalle->subtotal          = $subtotal + $detalle->montoiva - $detalle->montodesc - $detalle->montodesc1;

        $detalle->save();

        $detallecompra  = DetalleCompra::where('compra', $request->compra)->orderBy('id', 'DESC')->get();
        $view           = view('admin.detallecompras.detalle', compact('detallecompra'))->render();

        return response()->json($view);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $detalle    = DetalleCompra::find($request->id);
        $proveedor  = 
        $detalle->delete();

        $detallecompra  = DetalleCompra::where('compra', $request->compra)->orderBy('id', 'DESC')->get();
        $view           = view('admin.detallecompras.detalle', compact('detallecompra'))->render();

        return response()->json($view);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getproducto(Request $request)
    {

        if ($request->ajax()) {

            $id = $request->id;
            $producto = Producto::where('id', $id)->first();

            return response()->json([
                "precio" => $producto->preciolista
            ]);
        }
    }
}