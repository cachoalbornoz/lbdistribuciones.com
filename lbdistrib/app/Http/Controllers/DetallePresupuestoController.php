<?php

namespace App\Http\Controllers;

use App\Models\DetallePresupuesto;
use App\Models\Presupuesto;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;

class DetallePresupuestoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->palabra) {
                $productos = Producto::activo(1)->buscarnombre($request->palabra)->orderBy('codigobarra', 'ASC')->paginate(10);
            } else {
                $productos = Producto::activo(1)->orderBy('codigobarra', 'ASC')->paginate(10);
            }
            $view = view('admin.detallepresupuestos.detalleproducto', compact('productos'))->render();

            return response()->json($view);
        }

        if ($request->palabra) {
            $productos = Producto::activo(1)->buscarnombre($request->palabra)->orderBy('codigobarra', 'ASC')->paginate(10);
        } else {
            $productos = Producto::activo(1)->orderBy('codigobarra', 'ASC')->paginate(10);
        }

        $presupuesto        = Presupuesto::where('id', $request->id)->first();
        $detallepresupuesto = DetallePresupuesto::where('presupuesto', $request->id)->orderBy('id', 'DESC')->get();

        return view('admin.detallepresupuestos.index', compact('presupuesto', 'productos', 'detallepresupuesto'));
    }

    public function show($id)
    {
        $presupuesto        = Presupuesto::where('id', $id)->first();
        $detallepresupuesto = DetallePresupuesto::where('presupuesto', $id)->orderBy('id', 'ASC')->get();

        return view('admin.detallepresupuestos.show', compact('presupuesto', 'detallepresupuesto'));
    }

    public function facturacion($id)
    {
        $presupuesto        = Presupuesto::where('id', $id)->first();
        $detallepresupuesto = DetallePresupuesto::where('presupuesto', $id)->orderBy('id', 'ASC')->get();
        $total              = DetallePresupuesto::where('presupuesto', $id)->sum('cantidadentregada');
        //
        $Venta          = Venta::orderBy('nro', 'desc')->first();
        $nroComprobante = isset($Venta) ? $Venta->nro + 1 : 1;

        return view('admin.detallepresupuestos.facturacion', compact('presupuesto', 'detallepresupuesto', 'nroComprobante', 'total'));
    }

    public function insert(Request $request)
    {
        $detallepresupuesto = DetallePresupuesto::where('presupuesto', $request->presupuesto)->where('producto', $request->producto)->first();

        if (isset($detallepresupuesto)) { // ENCONTRO EL PRODUCTO

            $porcentaje                            = ($detallepresupuesto->descuento < 1) ? (1 - $detallepresupuesto->descuento) : $detallepresupuesto->descuento;
            $detallepresupuesto->precio            = $request->precio;
            $detallepresupuesto->cantidad          = $detallepresupuesto->cantidad + $request->cantidad;
            $detallepresupuesto->cantidadentregada = $detallepresupuesto->cantidad;
            $detallepresupuesto->iva               = ($request->precio * $detallepresupuesto->cantidad * 0.21);
            $detallepresupuesto->subtotal          = ($request->precio * $detallepresupuesto->cantidad * $porcentaje);
            $detallepresupuesto->montodesc         = ($request->precio * $detallepresupuesto->cantidad) - $detallepresupuesto->subtotal;
            $detallepresupuesto->save();
        } else { // "NO ENCONTRO" Y CREA

            $detalle = new DetallePresupuesto($request->all());

            $porcentaje         = ($request->descuento < 1) ? (1 - $request->descuento) : $request->descuento;
            $detalle->iva       = ($request->precio * $request->cantidad * 0.21);
            $detalle->subtotal  = ($request->precio * $request->cantidad * $porcentaje);
            $detalle->montodesc = ($request->precio * $request->cantidad) - $detalle->subtotal;
            $detalle->save();
        }

        $id                 = $request->presupuesto;
        $detallepresupuesto = DetallePresupuesto::where('presupuesto', $id)->orderBy('id', 'DESC')->get();
        $view               = view('admin.detallepresupuestos.detallepresupuesto', compact('detallepresupuesto'))->render();

        // ACTUALIZO LA FECHA MODIFICACION DEL PRESUPUESTO
        $presupuesto = Presupuesto::find($id);
        $presupuesto->touch();

        return response()->json($view);
    }

    public function update(Request $request)
    {
        $detallepresupuesto = DetallePresupuesto::find($request->id);
        $presupuesto        = $detallepresupuesto->presupuesto;

        if ($request->descuento < 1) {
            $porcentaje = (1 - $request->descuento);
        } else {
            $porcentaje = $request->descuento;
        }

        // Busco el valor actualizado del Producto
        $producto = Producto::find($detallepresupuesto->producto);

        $detallepresupuesto->cantidadentregada = $request->cant;
        $detallepresupuesto->precio            = $producto->precioventa;
        $detallepresupuesto->descuento         = $request->descuento;
        $detallepresupuesto->iva               = $producto->precioventa * $request->cant * 0.21;
        $detallepresupuesto->subtotal          = $producto->precioventa * $request->cant * $porcentaje;
        $detallepresupuesto->montodesc         = ($producto->precioventa * $request->cant) - $detallepresupuesto->subtotal;
        $detallepresupuesto->save();

        $id                 = $detallepresupuesto->presupuesto;
        $detallepresupuesto = DetallePresupuesto::where('presupuesto', $id)->get();
        $view               = view('admin.detallepresupuestos.detallefacturacion', compact('detallepresupuesto'))->render();

        return response()->json($view);
    }

    public function destroy(Request $request)
    {
        $detalle = DetallePresupuesto::find($request->id);
        $detalle->delete();

        // ACTUALIZO LA FECHA MODIFICACION DEL PRESUPUESTO
        $presupuesto = Presupuesto::find($detalle->presupuesto);
        $presupuesto->touch();

        $detallepresupuesto = DetallePresupuesto::where('presupuesto', $request->presupuesto)->orderBy('id', 'DESC')->get();
        $view               = view('admin.detallepresupuestos.detallepresupuesto', compact('detallepresupuesto'))->render();

        return response()->json($view);
    }
}
