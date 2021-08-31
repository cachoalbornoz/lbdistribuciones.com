<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Venta,
    App\Models\DetalleVenta,
    App\Models\Producto;

class DetalleVentaController extends Controller
{

    public function index($id)
    {
        $venta          = Venta::where('id', $id)->first();
        $detalleventa   = DetalleVenta::where('venta', $id)->orderBy('id', 'ASC')->get() ;
        $producto       = Producto::selectRaw('id, CONCAT(nombre," | $ ", precioVenta) as infoProducto')->orderBy('nombre','ASC')->pluck('infoProducto', 'id');

        return view('admin.detalleventas.index', compact('venta', 'detalleventa', 'producto'));
    }

    public function show($id)
    {
        $venta          = Venta::where('id', $id)->first();
        $detalleventa   = DetalleVenta::where('venta', $id)->orderBy('id', 'ASC')->get() ;

        return view('admin.detalleventas.show', compact('venta', 'detalleventa'));
    }


    public function insert(Request $request)
    {
        $detalleventa        = new DetalleVenta($request->all());

        $porcentaje = ($request->descuento < 1)?(1 - $request->descuento):$request->descuento;
        $detalleventa->iva       = ($request->precio * $request->cantidad * 0.21) ;
        $detalleventa->subtotal  = ($request->precio * $request->cantidad * $porcentaje);
        $detalleventa->montodesc = ($request->precio * $request->cantidad) - $detalleventa->subtotal ;
        $detalleventa->save();

        $venta          = $request->venta;
        $detalleventa   = DetalleVenta::where('venta', $venta)->orderBy('id', 'ASC')->get() ;
        $view       = view('admin.detalleventas.detalle', compact('detalleventa'))->render();

        return response()->json($view);
    }

    public function destroy(Request $request)
    {
        $detalle = DetalleVenta::find($request->id);
        $detalle->delete();

        $venta          = $request->venta;
        $detalleventa   = DetalleVenta::where('venta', $venta)->orderBy('id', 'ASC')->get() ;
        $view           = view('admin.detalleventas.detalle', compact('detalleventa'))->render();

        return response()->json($view);

    }

    public function getproducto(Request $request){

        if($request->ajax()){

            $id = $request->id;
            $producto = Producto::where('id', $id)->first();

            return response()->json([
                "precio" => $producto->precioventa
            ]);
        }
    }

}
