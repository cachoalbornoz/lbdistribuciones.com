<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests\VentaRequest;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Contacto;
use App\Models\TipoComprobante;
use App\Models\Vendedor;
use App\Models\TipoFormapago;
use App\Models\MovContacto;
use App\Models\Pedido;
use App\Models\Presupuesto;
use App\Models\Pendiente;
use App\Models\DetallePedido;
use App\Models\DetallePresupuesto;
use App\Models\Producto;

use Carbon\Carbon;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:venta.index')->only('index');
        $this->middleware('permission:venta.create')->only(['create', 'store']);
        $this->middleware('permission:venta.edit')->only(['edit', 'update']);
        $this->middleware('permission:venta.destroy')->only('destroy');
    }

    public function index()
    {
        $ventas     = Venta::orderBy('fecha', 'DESC')->get();
        $vendedor   = Vendedor::selectRaw('id, CONCAT(apellido," ",nombres) as nombreCompleto')->orderBy('apellido', 'ASC')->pluck('nombreCompleto', 'id');
        $total      = Venta::all()->sum('total');

        return view('admin.ventas.index', compact('ventas', 'vendedor', 'total'));
    }

    public function show(Request $request)
    {
        if ($request->quitar) {
            $ventas = Venta::orderBy('fecha', 'DESC')->get();
            $total  = Venta::all()->sum('total');
        } else {
            $vendedor  = Vendedor::where('id', $request->vendedor)->selectRaw('id, CONCAT(apellido," ",nombres) as nombreCompleto')->orderBy('apellido', 'ASC')->pluck('nombreCompleto', 'id');
            $ventas    = Venta::buscarvendedor($request->vendedor)->buscarfechas($request->desde, $request->hasta)->orderBy('fecha', 'DESC')->get();
            $total    = Venta::buscarvendedor($request->vendedor)->buscarfechas($request->desde, $request->hasta)->sum('total');
        }

        return view('admin.ventas.index', compact('ventas', 'vendedor', 'total'));
    }

    public function buscar(Request $request)
    {
        if ($request->ajax()) {
            if ($request->quitar) {
                $ventas = Venta::buscarcontacto($request->contacto)->orderBy('fecha', 'DESC')->get();
                $total  = Venta::buscarcontacto($request->contacto)->sum('total');
            } else {
                $ventas    = Venta::buscarcontacto($request->contacto)->buscarvendedor($request->vendedor)->buscarfechas($request->desde, $request->hasta)->orderBy('fecha', 'DESC')->get();
                $total    = Venta::buscarcontacto($request->contacto)->buscarvendedor($request->vendedor)->buscarfechas($request->desde, $request->hasta)->sum('total');
            }

            $view = view('admin.ventas.detalle', compact('ventas', 'total'))->render();

            return response()->json($view);
        }
    }

    public function ventaContacto($id)
    {
        $contacto   = Contacto::find($id);
        $ventas     = Venta::where('contacto', $id)->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')->get();

        // OBTENER TOTAL VENTAS
        $totalventa = Venta::where('contacto', $id)->where('tipocomprobante', '=', 2)->sum('total');
        // OBTENER TOTAL NOTA CREDITO
        $totalnotac = Venta::where('contacto', $id)->where('tipocomprobante', '=', 8)->sum('total');
        // CALCULAR TOTAL
        $total      = $totalventa - $totalnotac;

        return view('admin.ventas.index', compact('id', 'ventas', 'contacto', 'total'));
    }

    public function create(Request $request, $id = null)
    {
        $Venta          = Venta::orderBy('nro', 'desc')->first();
        $nroComprobante = isset($Venta) ? $Venta->nro + 1 : 1;

        if ($id) {
            $contacto   = $contacto   = Contacto::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
                ->where('id', $id)
                ->pluck('nombreCompleto', 'id');
        } else {
            $contacto   = Contacto::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
                ->orderBy('nombreEmpresa', 'ASC')
                ->pluck('nombreCompleto', 'id');
        }
        $tipocomprobante = TipoComprobante::where('id', '=', 2)->orWhere('id', '=', 8)
            ->orderBy('id', 'ASC')
            ->pluck('comprobante', 'id');
        $vendedor       = Vendedor::selectRaw('id, CONCAT(apellido," ",nombres) as nombreCompleto')->orderBy('apellido', 'ASC')->pluck('nombreCompleto', 'id');
        $formapago      = TipoFormapago::orderBy('id', 'DESC')->pluck('forma', 'id');

        return view('admin.ventas.create', compact('id', 'contacto', 'tipocomprobante', 'vendedor', 'formapago', 'nroComprobante'));
    }

    public function store(VentaRequest $request)
    {
        $venta = new Venta($request->all());
        $venta->save();

        return redirect()->route('detalleventa.index', ['id' => $venta->id]);
    }

    public function registrarVtaManual(Request $request)
    {
        $venta  = Venta::find($request->id);
        $nro    = $venta->nro;
        $total  = DetalleVenta::where('venta', '=', $request->id)->get()->sum('subtotal');

        // Actualizo TOTAL VENDIDO
        $venta->total = $total;
        $venta->save();

        $detalle = DetalleVenta::where('venta', '=', $request->id)->get();

        if ($detalle->count() > 0) {
            if ($detalle->count() == 1) {
                $detalle  = DetalleVenta::where('venta', $request->id)->first();
                $producto = Producto::find($detalle->producto);

                if ($request->tipocomprobante == 8) {   // NOTA CREDITO
                    $producto->stockactual = $producto->stockactual + $detalle->cantidad;
                } else {                                  // VENTA
                    $producto->stockactual = $producto->stockactual - $detalle->cantidad;
                }

                $producto->save();
            } else {
                foreach ($detalle as $deta) {
                    // ACTUALIZO STOCK PRODUCTO
                    $producto = Producto::find($deta->producto);

                    if ($request->tipocomprobante == 8) {   // NOTA CREDITO
                        $producto->stockactual = $producto->stockactual + $deta->cantidad;
                    } else {                                  // VENTA
                        $producto->stockactual = $producto->stockactual - $deta->cantidad;
                    }

                    $producto->save();
                }
            }
        }

        /////// ACTUALIZA SALDO CONTACTO

        $contacto   = Contacto::find($venta->contacto);
        $saldo      = $contacto->saldo;

        if ($request->tipocomprobante == 8) {   // NOTA CREDITO

            $nuevoSaldo = $saldo - $total;
            $concepto   = 'NOTA CREDITO';
            $debe       = 0;
            $haber      = $total;
        } else {                                // VENTA

            $nuevoSaldo = $saldo + $total;
            $concepto   = 'VENTA';
            $debe       = $total;
            $haber      = 0;
        }

        $contacto->saldo = $nuevoSaldo;
        $contacto->save();

        // BUSCO EL SALDO A ESA FECHA
        $datos      = MovContacto::where('contacto', $venta->contacto)
            ->whereDate('fecha', '<=', date($venta->fecha))
            ->orderBy('fecha', 'DESC')
            ->orderBy('id', 'DESC')->first();

        if (isset($datos)) {
            if ($request->tipocomprobante == 8) {   // NOTA CREDITO
                $nuevoSaldo = $datos->saldo - $venta->total;
            } else {
                $nuevoSaldo = $datos->saldo + $venta->total;
            }
        } else {
            $nuevoSaldo = $venta->total;
        }

        /////// AGREGA MOVIMIENTO DE CTA CTE
        $movimiento = new MovContacto();
        $movimiento->contacto       = $venta->contacto;
        $movimiento->tipocomprobante = $request->tipocomprobante;
        $movimiento->idcomprobante  = $venta->id;
        $movimiento->fecha          = $venta->fecha;
        $movimiento->concepto       = $concepto;
        $movimiento->nro            = $nro;
        $movimiento->debe           = $debe;
        $movimiento->haber          = $haber;
        $movimiento->saldo          = $nuevoSaldo;

        $movimiento->save();

        // ACTUALIZO LOS SALDOS
        $movimientos = MovContacto::where('contacto', $venta->contacto)
            ->whereDate('fecha', '>', date($venta->fecha))
            ->orderBy('fecha', 'ASC')->get();

        foreach ($movimientos as $movimiento) {
            $movimiento->saldo  = $nuevoSaldo + $movimiento->debe - $movimiento->haber;
            $nuevoSaldo         = $movimiento->saldo;
            $movimiento->save();
        }

        // ELIMINO PEDIDOS/PENDIENTES CON FECHA MAYOR A 60 DIAS
        $dias   = (new Carbon)->submonths(2);
        // Pedido::where("created_at", '<', $dias)->delete();
        Pendiente::where("created_at", '<', $dias)->delete();

        return response()->json();
    }

    public function registrarVtaP(Request $request)
    {
        $id         = $request->id_presupuesto;
        $presupuesto = Presupuesto::find($id);
        $nro        = $request->nro;

        $total      = DetallePresupuesto::where('presupuesto', '=', $id)->get()->sum('subtotal');

        $venta = new Venta();
        $venta->tipocomprobante = 2; // Presupesto
        $venta->vendedor        = $presupuesto->vendedor;
        $venta->contacto        = $presupuesto->contacto;
        $venta->fecha           = $request->fecha;
        $venta->observaciones   = $request->observaciones;
        $venta->nro             = $nro;
        $venta->total           = $total;
        $venta->formapago       = $presupuesto->formapago;
        $venta->presupuesto     = $id;
        $venta->save();

        // CAMBIAR ESTADO AL PRESUPUESTO => 1 "FACTURADO"
        $presupuesto->estado = 1;
        $presupuesto->save();


        // TRASPASA LOS DETALLE DE PRESUPUESTO
        $detalle = DetallePresupuesto::where('presupuesto', '=', $id)->get();

        foreach ($detalle as $detallePresupuesto) {
            if ($detallePresupuesto->cantidadentregada > 0) {     // PREGUNTAR SI ENTREGO AL MENOS UN PRODUCTO Y PASARLO A LA VENTA

                $detalleVta             = new DetalleVenta();
                $detalleVta->producto   = $detallePresupuesto->producto;
                $detalleVta->venta      = $venta->id;
                $detalleVta->precio     = $detallePresupuesto->precio;
                $detalleVta->cantidad   = $detallePresupuesto->cantidadentregada;
                $detalleVta->descuento  = $detallePresupuesto->descuento;
                $detalleVta->montodesc  = $detallePresupuesto->montodesc;
                $detalleVta->iva        = $detallePresupuesto->iva;
                $detalleVta->subtotal   = $detallePresupuesto->subtotal;
                $detalleVta->save();

                // ACTUALIZO STOCK PRODUCTO
                $producto = Producto::find($detallePresupuesto->producto);
                $producto->stockactual = $producto->stockactual - $detallePresupuesto->cantidadentregada;
                $producto->save();
            }
        }

        /////// ACTUALIZA SALDO CONTACTO
        $contacto       = Contacto::find($presupuesto->contacto);
        $saldo          = $contacto->saldo;

        $nuevoSaldo     = $saldo + $total;
        $concepto       = 'VENTA';
        $debe           = $total;
        $haber          = 0;
        $contacto->saldo = $nuevoSaldo;
        $contacto->save();

        // BUSCO EL SALDO A ESA FECHA
        $datos      = MovContacto::where('contacto', $presupuesto->contacto)
            ->whereDate('fecha', '<=', $presupuesto->fecha)
            ->orderBy('fecha', 'DESC')
            ->orderBy('id', 'DESC')->first();

        if (isset($datos)) {
            $nuevoSaldo = $datos->saldo + $total;
        } else {
            $nuevoSaldo = $total;
        }

        /////// AGREGA MOVIMIENTO DE CTA CTE
        $movimiento = new MovContacto();
        $movimiento->contacto       = $venta->contacto;
        $movimiento->tipocomprobante = 2;
        $movimiento->idcomprobante  = $venta->id;
        $movimiento->fecha          = $venta->fecha;
        $movimiento->concepto       = $concepto;
        $movimiento->nro            = $venta->nro;
        $movimiento->debe           = $debe;
        $movimiento->haber          = $haber;
        $movimiento->saldo          = $nuevoSaldo;
        $movimiento->save();

        // ACTUALIZO LOS SALDOS
        $movimientos = MovContacto::where('contacto', $presupuesto->contacto)
            ->whereDate('fecha', '>', $presupuesto->fecha)
            ->orderBy('fecha', 'ASC')->get();

        foreach ($movimientos as $movimiento) {
            $movimiento->saldo  = $nuevoSaldo + $movimiento->debe - $movimiento->haber;
            $nuevoSaldo         = $movimiento->saldo;
            $movimiento->save();
        }

        return redirect()->route('venta.ventaContacto', $contacto->id);
    }

    public function registrarVta(Request $request)
    {
        $id         = $request->id_pedido;
        $pedido     = Pedido::find($id);
        $nro        = $request->nro;
        $contacto   = Contacto::find($pedido->contacto);

        $cantidadEntregada  = DetallePedido::where('pedido', $id)->where('cantidadentregada', '>', 0)->sum('cantidadentregada');


        if ($cantidadEntregada > 0) {

            $total = 0;

            $venta = new Venta();
            $venta->tipocomprobante = 2; // Presupesto
            $venta->vendedor        = $pedido->vendedor;
            $venta->contacto        = $pedido->contacto;
            $venta->fecha           = $request->fecha;
            $venta->observaciones   = $request->observaciones;
            $venta->nro             = $nro;
            $venta->formapago       = $pedido->formapago;
            $venta->pedido          = $id;
            $venta->total           = $total;
            $venta->save();

            // CAMBIAR ESTADO AL PEDIDO => 1 "FACTURADO"
            $pedido->estado = 1;
            $pedido->save();

            // 
            $notification = array(
                'message' => 'Se registró la venta correctamente !',
                'alert-type' => 'success'
            );

            // TRASPASA LOS DETALLE DE PEDIDO
            $detalle = DetallePedido::where('pedido', '=', $id)->get();

            foreach ($detalle as $detallePedido) {

                if ($detallePedido->descuento < 1) {
                    $porcentaje = (1 - $detallePedido->descuento);
                } else {
                    $porcentaje = $detallePedido->descuento;
                }

                $detallePedido->iva                  = $detallePedido->precio * $detallePedido->cantidadentregada * 0.21;
                $detallePedido->subtotal             = $detallePedido->precio * $detallePedido->cantidadentregada * $porcentaje;
                $detallePedido->montodesc            = ($detallePedido->precio * $detallePedido->cantidadentregada) - $detallePedido->subtotal;
                $detallePedido->save();

                if ($detallePedido->cantidadentregada > 0) {     // PREGUNTAR SI ENTREGO AL MENOS UN PRODUCTO Y PASARLO A LA VENTA

                    $detalleVta             = new DetalleVenta();
                    $detalleVta->producto   = $detallePedido->producto;
                    $detalleVta->venta      = $venta->id;
                    $detalleVta->precio     = $detallePedido->precio;
                    $detalleVta->cantidad   = $detallePedido->cantidadentregada;
                    $detalleVta->descuento  = $detallePedido->descuento;
                    $detalleVta->montodesc  = $detallePedido->montodesc;
                    $detalleVta->iva        = $detallePedido->iva;
                    $detalleVta->subtotal   = $detallePedido->subtotal;
                    $detalleVta->save();

                    // ACTUALIZO STOCK PRODUCTO
                    $producto = Producto::find($detallePedido->producto);
                    $producto->stockactual = $producto->stockactual - $detallePedido->cantidadentregada;
                    $producto->save();
                }

                // CARGO PENDIENTES SI EXISTEN DIFERENCIAS
                if ($detallePedido->cantidadentregada < $detallePedido->cantidad) {

                    $nuevoPendiente = new Pendiente();
                    $nuevoPendiente->contacto   = $pedido->contacto;
                    $nuevoPendiente->producto   = $detallePedido->producto;
                    $nuevoPendiente->precio     = $detallePedido->precio;
                    $nuevoPendiente->cantidad   = $detallePedido->cantidad - $detallePedido->cantidadentregada;
                    $nuevoPendiente->descuento  = $detallePedido->descuento;
                    $nuevoPendiente->save();

                    $notification = array(
                        'message' => 'Se generaron movimientos pendientes !',
                        'alert-type' => 'info'
                    );
                }
            }

            $total              = DetallePedido::where('pedido', $id)->sum('subtotal');
            $venta->total       = $total;
            $venta->save();

            /////// ACTUALIZA SALDO CONTACTO
            $saldo              = $contacto->saldo;
            $nuevoSaldo         = $saldo + $total;
            $concepto           = 'VENTA';
            $debe               = $total;
            $haber              = 0;
            $contacto->saldo    = $nuevoSaldo;
            $contacto->save();

            // BUSCO EL SALDO A ESA FECHA
            $datos      = MovContacto::where('contacto', $pedido->contacto)
                ->whereDate('fecha', '<=', $pedido->fecha)
                ->orderBy('fecha', 'DESC')
                ->orderBy('id', 'DESC')->first();

            if (isset($datos)) {
                $nuevoSaldo = $datos->saldo + $total;
            } else {
                $nuevoSaldo = $total;
            }

            /////// AGREGA MOVIMIENTO DE CTA CTE
            $movimiento = new MovContacto();
            $movimiento->contacto       = $venta->contacto;
            $movimiento->tipocomprobante = 2;
            $movimiento->idcomprobante  = $venta->id;
            $movimiento->fecha          = $venta->fecha;
            $movimiento->concepto       = $concepto;
            $movimiento->nro            = $venta->nro;
            $movimiento->debe           = $debe;
            $movimiento->haber          = $haber;
            $movimiento->saldo          = $nuevoSaldo;
            $movimiento->save();

            // ACTUALIZO LOS SALDOS
            $movimientos = MovContacto::where('contacto', $pedido->contacto)
                ->whereDate('fecha', '>', $pedido->fecha)
                ->orderBy('fecha', 'ASC')->get();

            foreach ($movimientos as $movimiento) {
                $movimiento->saldo  = $nuevoSaldo + $movimiento->debe - $movimiento->haber;
                $nuevoSaldo         = $movimiento->saldo;
                $movimiento->save();
            }
        } else {

            $notification = array(
                'message' => 'No se generó ningún movimiento !',
                'alert-type' => 'error'
            );
        }

        // ELIMINO PEDIDOS/PENDIENTES CON FECHA MAYOR A 60 DIAS
        // $dias   = (new Carbon)->submonths(2) ;
        // Pedido::where("created_at", '<', $dias)->delete();
        // Pendiente::where("created_at", '<', $dias)->delete();

        return redirect()->route('venta.ventaContacto', $contacto->id)->with($notification);
    }

    public function destroy(Request $request)
    {
        $venta      = Venta::find($request->id);
        $contacto   = $venta->contacto;
        $venta->delete();

        // ANULO EL MOVIMIENTO
        $movimiento = MovContacto::where('idcomprobante', $request->id);
        $movimiento->delete();

        // ACTUALIZO EL SALDO
        $Contacto   = Contacto::find($contacto);
        $nuevoSaldo = 0;
        $movimientos= MovContacto::where('contacto', $contacto)->orderBy('fecha', 'ASC')->get();
        foreach ($movimientos as $movimiento) {
            $movimiento->saldo  = $nuevoSaldo + $movimiento->debe - $movimiento->haber;
            $nuevoSaldo         = $movimiento->saldo;
            $movimiento->save();
        }
        $Contacto->saldo = abs($nuevoSaldo);
        $Contacto->save();

        $ventas     = Venta::where('contacto', $contacto)->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')->get();
        $totalventa = Venta::where('contacto', $contacto)->where('tipocomprobante', '=', 2)->sum('total');
        $totalnotac = Venta::where('contacto', $contacto)->where('tipocomprobante', '=', 8)->sum('total');
        $total      = $totalventa - $totalnotac;

        $vistaVentas= view('admin.ventas.detalle', compact('ventas', 'total', 'contacto'))->render();
        return response()->json($vistaVentas);
    }
}