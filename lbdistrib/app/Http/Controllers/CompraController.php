<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests\CompraRequest;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Proveedor;
use App\Models\TipoComprobante;
use App\Models\TipoFormapago;
use App\Models\MovProveedor;
use App\Models\Producto;

use Carbon\Carbon;

class CompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:compra.index')->only('index');
        $this->middleware('permission:compra.create')->only(['create', 'store']);
        $this->middleware('permission:compra.edit')->only(['edit', 'update']);
        $this->middleware('permission:compra.destroy')->only('destroy');
    }

    public function index(){
        $compras = Compra::orderBy('fecha', 'DESC')->orderBy('id', 'DESC')->get();
        return view('admin.compras.index', compact('compras'));
    }

    public function compraProveedor($id) {
        $compras    = Compra::where('proveedor', $id)->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')->get();
        $proveedor  = Proveedor::find($id);
        return view('admin.compras.index', compact('id', 'compras', 'proveedor'));
    }

    public function create(Request $request, $id = null){
        $Compra          = Compra::orderBy('nro', 'desc')->first();
        $nroComprobante  = isset($Compra) ? $Compra->nro + 1 : 1;

        if ($id) {
            $proveedor   = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
                ->where('id', $id)
                ->pluck('nombreCompleto', 'id');
        } else {
            $proveedor   = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
                ->orderBy('nombreEmpresa', 'ASC')
                ->pluck('nombreCompleto', 'id');    
        }
        
        $tipocomprobante = TipoComprobante::where('id', '=', 2)->orWhere('id', '=', 8)->orderBy('id', 'ASC')->pluck('comprobante', 'id');
        $tipoformapago   = TipoFormapago::orderBy('id', 'DESC')->pluck('forma', 'id');

        return view('admin.compras.create', compact('id', 'proveedor', 'tipocomprobante', 'tipoformapago', 'nroComprobante'));
    }

    public function store(CompraRequest $request) {
        $compra = new Compra($request->all());
        $compra->total = 0;
        $compra->save();

        return redirect()->route('detallecompra.index', ['id' => $compra->id]);
    }

    public function edit(Request $request) {
        $id                 = $request->id;
        $compra             = Compra::find($id);
        $proveedor          = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')->orderBy('nombreEmpresa', 'ASC')->pluck('nombreCompleto', 'id');
        $tipocomprobante    = TipoComprobante::where('id', '=', 2)->orWhere('id', '=', 8)->orderBy('id', 'ASC')->pluck('comprobante', 'id');
        $tipoformapago      = TipoFormapago::orderBy('id', 'DESC')->pluck('forma', 'id');

        return view('admin.compras.edit', compact('compra', 'proveedor', 'tipocomprobante', 'tipoformapago'));
    }

    public function update(Request $request) {
        $id         = $request->compra;
        $compra     = Compra::find($id)->update($request->all());
        return redirect()->route('compra.index');
    }

    public function registrarCpra(Request $request) {

        $compra     = Compra::find($request->id);
        $nro        = $compra->nro;
        $total      = DetalleCompra::where('compra', '=', $request->id)->sum('subtotal');

        // Actualizo TOTAL COMPRADO
        $compra->total  = $total;
        $compra->save();

        $detalle = DetalleCompra::where('compra', '=', $request->id)->get();

        if ($detalle->count() > 0) {
            if ($detalle->count() == 1) {
                $detalle  = DetalleCompra::where('compra', $request->id)->first();
                $producto = Producto::find($detalle->producto);

                if ($request->tipocomprobante == 8) {   // NOTA CREDITO
                    $producto->stockactual = $producto->stockactual - $detalle->cantidad;
                } else {                                  // COMPRA
                    $producto->stockactual = $producto->stockactual + $detalle->cantidad;
                }
                $producto->save();
            } else {
                foreach ($detalle as $deta) {
                    // ACTUALIZO STOCK PRODUCTO
                    $producto = Producto::find($deta->producto);

                    if ($request->tipocomprobante == 8) {   // NOTA CREDITO
                        $producto->stockactual = $producto->stockactual - $deta->cantidad;
                    } else {                                  // VENTA
                        $producto->stockactual = $producto->stockactual + $deta->cantidad;
                    }
                    $producto->save();
                }
            }
        }

        /////// ACTUALIZA SALDO CONTACTO
        $proveedor       = Proveedor::find($compra->proveedor);
        $saldo           = $proveedor->saldo;

        if ($request->tipocomprobante == 8) {   // NOTA CREDITO

            $nuevoSaldo = $saldo - $total;
            $concepto   = 'NOTA CREDITO';
            $debe       = 0;
            $haber      = $total;
        } else {                                // COMPRA

            $nuevoSaldo = $saldo + $total;
            $concepto   = 'COMPRA';
            $debe       = $total;
            $haber      = 0;
        }

        $proveedor->saldo = $nuevoSaldo;
        $proveedor->save();     
        
        // BUSCO EL SALDO A ESA FECHA
        $datos      = MovProveedor::where('proveedor', $compra->proveedor)
            ->whereDate('fecha', '<=', $compra->fecha)
            ->orderBy('fecha', 'DESC')
            ->orderBy('id', 'DESC')->first();

        if (isset($datos)) {
            if ($request->tipocomprobante == 8) {   // NOTA CREDITO
                $nuevoSaldo = $datos->saldo - $compra->total;
            } else {
                $nuevoSaldo = $datos->saldo + $compra->total;
            }
        } else {
            $nuevoSaldo = $compra->total;
        }

        /////// AGREGA MOVIMIENTO DE CTA CTE
        $movimiento = new MovProveedor();
        $movimiento->proveedor       = $compra->proveedor;
        $movimiento->tipocomprobante = $request->tipocomprobante;
        $movimiento->idcomprobante   = $compra->id;
        $movimiento->fecha           = $compra->fecha;
        $movimiento->concepto        = $concepto;
        $movimiento->nro             = $compra->nro;
        $movimiento->debe            = $debe;
        $movimiento->haber           = $haber;
        $movimiento->saldo           = $nuevoSaldo;
        $movimiento->save();

        // ACTUALIZO LOS SALDOS
        $movimientos = MovProveedor::where('proveedor', $compra->proveedor)
            ->whereDate('fecha', '>', date($compra->fecha))
            ->orderBy('fecha', 'ASC')->get();

        foreach ($movimientos as $movimiento) {
            $movimiento->saldo  = $nuevoSaldo + $movimiento->debe - $movimiento->haber;
            $nuevoSaldo         = $movimiento->saldo;
            $movimiento->save();
        }

        return response()->json(['proveedor' => $proveedor]);
    }

    public function show(Request $request) {
        $compras    = Compra::orderBy('fecha', 'DESC')->get();
        return view('admin.compras.index', compact('compras'));
    }

    public function destroy(Request $request){

        $compra     = Compra::find($request->id);
        $proveedor  = $compra->proveedor;
        $compra->delete();

        // ANULO EL MOVIMIENTO
        $movimiento = MovProveedor::where('idcomprobante', $request->id);
        $movimiento->delete();

        // ACTUALIZO EL SALDO
        $Proveedor   = Proveedor::find($proveedor);
        $nuevoSaldo = 0;
        $movimientos= MovProveedor::where('proveedor', $proveedor)->orderBy('fecha', 'ASC')->get();
        foreach ($movimientos as $movimiento) {
            $movimiento->saldo  = $nuevoSaldo + $movimiento->debe - $movimiento->haber;
            $nuevoSaldo         = $movimiento->saldo;
            $movimiento->save();
        }
        $Proveedor->saldo = abs($nuevoSaldo);
        $Proveedor->save();

        $compras    = Compra::where('proveedor', $proveedor)->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')->get();

        $vistaCompras= view('admin.compras.detalle', compact('compras', 'proveedor'))->render();

        return response()->json($vistaCompras);
    }
}