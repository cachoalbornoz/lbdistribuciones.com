<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedido,
    App\Models\Venta,
    App\Models\Pendiente,
    App\Models\DetallePedido,
    App\Models\Producto;

class DetallePedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:detallepedido.facturacion')->only('facturacion');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            if ($request->palabra) {
                $productos      = Producto::activo(1)->buscarnombre($request->palabra)->orderBy('codigobarra', 'ASC')->paginate(10);
            } else {
                $productos      = Producto::activo(1)->orderBy('codigobarra', 'ASC')->paginate(10);
            }
            $view               = view('admin.detallepedidos.detalleproducto', compact('productos'))->render();

            return response()->json($view);
        }

        if ($request->palabra) {
            $productos      = Producto::activo(1)->buscarnombre($request->palabra)->orderBy('codigobarra', 'ASC')->paginate(10);
        } else {
            $productos      = Producto::activo(1)->orderBy('codigobarra', 'ASC')->paginate(10);
        }

        $pedido         = Pedido::where('id', $request->id)->first();
        $detallepedido  = DetallePedido::where('pedido', $request->id)->orderBy('id', 'ASC')->get();

        return view('admin.detallepedidos.index', compact('pedido', 'productos', 'detallepedido'));
    }

    public function show($id)
    {
        $pedido         = Pedido::where('id', $id)->first();
        $detallepedido  = DetallePedido::where('pedido', $id)->orderBy('id', 'ASC')->get();

        return view('admin.detallepedidos.show', compact('pedido', 'detallepedido'));
    }

    public function edit(Request $id)
    {
        $pedido         = Pedido::where('id', $id)->first();
        $detallepedido  = DetallePedido::where('pedido', $id)->orderBy('id', 'ASC')->get();

        return view('admin.detallepedidos.edit', compact('pedido', 'detallepedido'));
    }

    public function facturacion($id)
    {
        $pedido         = Pedido::where('id', $id)->first();
        $detallepedido  = DetallePedido::where('pedido', $id)->orderBy('id', 'ASC')->get();

        $cantEntregado      = DetallePedido::where('pedido', $id)->sum('cantidadentregada');
        $cantPedido         = DetallePedido::where('pedido', $id)->sum('cantidad');
        $subtotalEntregado  = DetallePedido::where('pedido', $id)->where('cantidadentregada', '>', 0)->sum('subtotal');

        //
        $Venta          = Venta::orderBy('nro', 'desc')->first();
        $nroComprobante = isset($Venta) ? $Venta->nro + 1 : 1;

        return view(
            'admin.detallepedidos.facturacion',
            compact(
                'pedido',
                'detallepedido',
                'nroComprobante',
                'cantEntregado',
                'cantPedido',
                'subtotalEntregado',
            )
        );
    }

    public function update(Request $request)
    {
        $detallepedido    = DetallePedido::find($request->id);

        $pedido     = $detallepedido->pedido;

        if ($request->descuento < 1) {
            $porcentaje = (1 - $request->descuento);
        } else {
            $porcentaje = $request->descuento;
        }

        $detallepedido->cantidadentregada   = $request->cant;
        $precio                             = $detallepedido->precio;
        $detallepedido->descuento           = $request->descuento;
        $detallepedido->iva                 = $precio * $request->cant * 0.21;
        $detallepedido->subtotal            = $precio * $request->cant * $porcentaje;
        $detallepedido->montodesc           = ($precio * $request->cant) - $detallepedido->subtotal;
        $detallepedido->save();

        $id             = $detallepedido->pedido;
        $cantEntregado      = DetallePedido::where('pedido', $id)->sum('cantidadentregada');
        $cantPedido         = DetallePedido::where('pedido', $id)->sum('cantidad');
        $subtotalEntregado  = DetallePedido::where('pedido', $id)->where('cantidadentregada', '>', 0)->sum('subtotal');

        $view           = view(
            'admin.detallepedidos.detalletotal',
            compact(
                'cantEntregado',
                'cantPedido',
                'subtotalEntregado',
            )
        )->render();

        return response()->json($view);
    }


    public function pendiente(Request $request)
    {
        $detalle = DetallePedido::find($request->id);

        $pendiente              = new Pendiente();
        $pendiente->contacto    = $request->contacto;
        $pendiente->producto    = $detalle->producto;
        $pendiente->precio      = $detalle->precio;
        $pendiente->cantidad    = $detalle->cantidad;
        $pendiente->precio      = $detalle->precio;
        $pendiente->descuento   = $detalle->descuento;
        $pendiente->subtotal    = $detalle->precio * $detalle->cantidad * (1 - $detalle->descuento);
        $pendiente->save();

        $detalle->delete();

        return response()->json($pendiente);
    }


    public function pedido(Request $request)
    {
        $pendiente = Pendiente::find($request->id);

        $detalle            = new DetallePedido();
        $detalle->pedido    = $request->pedido;
        $detalle->producto  = $pendiente->producto;
        $detalle->precio    = $pendiente->precio;
        $detalle->cantidad  = $pendiente->cantidad;
        $detalle->precio    = $pendiente->precio;
        $detalle->descuento = $pendiente->descuento;
        $detalle->subtotal  = $pendiente->precio * $pendiente->cantidad * (1 - $pendiente->descuento);
        $detalle->save();

        $pendiente->delete();

        return response()->json($detalle);
    }


    public function insert(Request $request)
    {

        $detallepedido   = DetallePedido::where('pedido', $request->pedido)->where('producto', $request->producto)->first();

        if (isset($detallepedido)) {                         // ENCONTRO EL PRODUCTO 

            if ($detallepedido->descuento < 1) {
                $porcentaje = (1 - $detallepedido->descuento);
            } else {
                $porcentaje = $detallepedido->descuento;
            }
            $detallepedido->precio               = $request->precio;
            $detallepedido->cantidad             = $detallepedido->cantidad + $request->cantidad;
            $detallepedido->cantidadentregada    = $detallepedido->cantidad;
            $detallepedido->iva                  = ($request->precio * $detallepedido->cantidad * 0.21);
            $detallepedido->subtotal             = ($request->precio * $detallepedido->cantidad * $porcentaje);
            $detallepedido->montodesc            = ($request->precio * $detallepedido->cantidad) - $detallepedido->subtotal;

            $detallepedido->save();
        } else {                                              // "NO ENCONTRO" Y CREA

            $detalle        = new DetallePedido($request->all());

            if ($request->descuento < 1) {
                $porcentaje = (1 - $request->descuento);
            } else {
                $porcentaje = $request->descuento;
            }

            $detalle->iva       = ($request->precio * $request->cantidad * 0.21);
            $detalle->subtotal  = ($request->precio * $request->cantidad * $porcentaje);
            $detalle->montodesc = ($request->precio * $request->cantidad) - $detalle->subtotal;
            $detalle->save();
        }
        $id             = $request->pedido;
        $detallepedido  = DetallePedido::where('pedido', $id)->orderBy('id', 'DESC')->get();
        $view           = view('admin.detallepedidos.detallepedido', compact('detallepedido'))->render();

        return response()->json($view);
    }

    public function destroy(Request $request)
    {
        $detalle = DetallePedido::find($request->id);
        $detalle->delete();

        $detallepedido  = DetallePedido::where('pedido', $request->pedido)->orderBy('id', 'DESC')->get();
        $view           = view('admin.detallepedidos.detallepedido', compact('detallepedido'))->render();

        return response()->json($view);
    }
}
