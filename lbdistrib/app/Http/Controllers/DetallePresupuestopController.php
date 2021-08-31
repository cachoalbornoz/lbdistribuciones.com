<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Presupuestop,
    App\Models\Venta,
    App\Models\DetallePresupuestop,
    App\Models\Producto;

class DetallePresupuestopController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            if ($request->palabra) {
                $productos      = Producto::activo(1)->buscarnombre($request->palabra)->orderBy('codigobarra', 'ASC')->paginate(10);
            } else {
                $productos      = Producto::activo(1)->orderBy('codigobarra', 'ASC')->paginate(10);
            }
            $view               = view('admin.detallepresupuestosp.detalleproducto', compact('productos'))->render();

            return response()->json($view);
        }

        if ($request->palabra) {
            $productos      = Producto::activo(1)->buscarnombre($request->palabra)->orderBy('codigobarra', 'ASC')->paginate(10);
        } else {
            $productos      = Producto::activo(1)->orderBy('codigobarra', 'ASC')->paginate(10);
        }

        $presupuesto         = Presupuestop::where('id', $request->id)->first();
        $detallepresupuesto  = DetallePresupuestop::where('presupuestop', $request->id)->orderBy('id', 'ASC')->get();

        return view('admin.detallepresupuestosp.index', compact('presupuesto', 'productos', 'detallepresupuesto'));
    }

    public function show($id)
    {

        $presupuesto         = Presupuestop::where('id', $id)->first();

        $detallepresupuesto  = DetallePresupuestop::where('presupuestop', $id)->orderBy('id', 'ASC')->get();

        return view('admin.detallepresupuestosp.show', compact('presupuesto', 'detallepresupuesto'));
    }

    public function insert(Request $request)
    {

        $detallepresupuesto   = DetallePresupuestop::where('presupuestop', $request->presupuesto)->where('producto', $request->producto)->first();

        if (isset($detallepresupuesto)) {                         // ENCONTRO EL PRODUCTO 

            if ($detallepresupuesto->descuento < 1) {
                $porcentaje = (1 - $detallepresupuesto->descuento);
            } else {
                $porcentaje = $detallepresupuesto->descuento;
            }
            $detallepresupuesto->precio                 = $request->precio;
            $detallepresupuesto->cantidad               = $detallepresupuesto->cantidad + $request->cantidad;
            $detallepresupuesto->descuento              = $detallepresupuesto->descuento;
            $detallepresupuesto->cantidadentregada      = $detallepresupuesto->cantidad;
            $detallepresupuesto->iva                    = ($request->precio * $detallepresupuesto->cantidad * 0.21);
            $detallepresupuesto->subtotal               = ($request->precio * $detallepresupuesto->cantidad * $porcentaje);
            $detallepresupuesto->montodesc              = ($request->precio * $detallepresupuesto->cantidad) - $detallepresupuesto->subtotal;

            $detallepresupuesto->save();
        } else {                                              // "NO ENCONTRO" Y CREA

            $detalle        = new DetallePresupuestop($request->all());

            if ($request->descuento < 1) {
                $porcentaje = (1 - $request->descuento);
            } else {
                $porcentaje = $request->descuento;
            }

            $detalle->descuento = $request->descuento;
            $detalle->iva       = ($request->precio * $request->cantidad * 0.21);
            $detalle->subtotal  = ($request->precio * $request->cantidad * $porcentaje);
            $detalle->montodesc = ($request->precio * $request->cantidad) - $detalle->subtotal;
            $detalle->save();
        }


        $id                 = $request->presupuestop;
        $detallepresupuesto = DetallePresupuestop::where('presupuestop', $id)->orderBy('id', 'DESC')->get();
        $view               = view('admin.detallepresupuestosp.detallepresupuesto', compact('detallepresupuesto'))->render();

        // ACTUALIZO LA FECHA MODIFICACION DEL PRESUPUESTO
        $presupuesto    = Presupuestop::find($id);
        $presupuesto->touch();

        return response()->json($view);
    }

    public function update(Request $request)
    {

        $detallepresupuesto = DetallePresupuestop::find($request->id);
        $presupuesto        = $detallepresupuesto->presupuesto;

        if ($request->descuento < 1) {
            $porcentaje = (1 - $request->descuento);
        } else {
            $porcentaje = $request->descuento;
        }

        $detallepresupuesto->cantidadentregada  = $request->cant;
        $precio                                 = $detallepresupuesto->precio;
        $detallepresupuesto->descuento          = $request->descuento;
        $detallepresupuesto->iva                = $precio * $request->cant * 0.21;
        $detallepresupuesto->subtotal           = $precio * $request->cant * $porcentaje;
        $detallepresupuesto->montodesc          = ($precio * $request->cant) - $detallepresupuesto->subtotal;
        $detallepresupuesto->save();

        $id     = $detallepresupuesto->presupuesto;
        $total  = DetallePresupuestop::where('presupuestop', $id)->sum('cantidadentregada');
        $view   = view('admin.detallepedidosp.detalletotal', compact('total'))->render();

        return response()->json($view);
    }

    public function destroy(Request $request)
    {
        $detalle = DetallePresupuestop::find($request->id);
        $detalle->delete();
        
        // ACTUALIZO LA FECHA MODIFICACION DEL PRESUPUESTO
        $presupuesto    = Presupuestop::find($request->presupuesto);
        $presupuesto->touch();

        $detallepresupuesto  = DetallePresupuestop::where('presupuestop', $request->presupuesto)->orderBy('id', 'DESC')->get();
        $view           = view('admin.detallepresupuestosp.detallepresupuesto', compact('detallepresupuesto'))->render();

        return response()->json($view);
    }
}