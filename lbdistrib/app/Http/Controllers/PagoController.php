<?php

namespace App\Http\Controllers;

use App\Models\Pago,
    App\Models\DetallePago,
    App\Models\Compra,
    App\Models\Proveedor,
    App\Models\TipoComprobante,
    App\Models\Vendedor,
    App\Models\TipoFormapago,
    App\Models\MovCheque,
    App\Models\MovProveedor;

use Illuminate\Http\Request;
use App\Http\Requests\PagoRequest;

use Carbon\Carbon;


class PagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pago.index')->only('index');
        $this->middleware('permission:pago.create')->only(['create', 'store']);
        $this->middleware('permission:pago.edit')->only(['edit', 'update']);
        $this->middleware('permission:pago.destroy')->only('destroy');
    }

    public function index(){

        $pagos      = Pago::orderBy('fecha', 'DESC')->orderBy('nro', 'DESC')->get();
        return view('admin.pagos.index', compact('pagos'));
    }

    public function pagoProveedor($id){
        $pagos      = Pago::orderBy('fecha', 'DESC')->orderBy('nro', 'DESC')->where('proveedor', $id)->get();
        $proveedor  = Proveedor::find($id);
        return view('admin.pagos.index', compact('id', 'pagos', 'proveedor'));
    }

    public function create($id)
    {
        $Pago           = Pago::orderBy('nro', 'desc')->first();
        $nroPago        = isset($Pago) ? $Pago->nro + 1 : 1; 
        
        if($id){
            $proveedor   = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
            ->where('id', $id)
            ->pluck('nombreCompleto', 'id');
        }else{
            $proveedor = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
            ->orderBy('nombreEmpresa','ASC')
            ->pluck('nombreCompleto', 'id');
        }        
        $arrComprobante = [9,16,17];
        $tipocomprobante= TipoComprobante::WhereIn('id', $arrComprobante)->orderBy('id','DESC')->pluck('comprobante', 'id');
        return view('admin.pagos.create', compact('id', 'proveedor', 'tipocomprobante', 'nroPago'));
    }

    public function store(PagoRequest $request)
    {
        $pago = new Pago($request->all());
        $pago->save();

        /////// ACTUALIZA SALDO CONTACTO

        $proveedor   = Proveedor::find($request->proveedor);
        $saldo      = $proveedor->saldo;
        $total      = $request->total ;

        if ($request->tipocomprobante == 16) {   // RECIBO

            $nuevoSaldo = $saldo - $total ;
            $concepto   = 'RECIBO';
            $debe       = 0;
            $haber      = $total;

        } else {                                
            
            if ($request->tipocomprobante == 9) {   // NOTA DEBITO
                $nuevoSaldo = $saldo + $total ;
                $concepto   = 'NOTA DEBITO';
                $debe       = $total;
                $haber      = 0;
                
            }else{

                $nuevoSaldo = $saldo + $total ;
                $concepto   = 'ORDEN PAGO';
                $debe       = $total;
                $haber      = 0;
            }
        }

        $proveedor->saldo= $nuevoSaldo;
        $proveedor->save();

        /////// AGREGA MOVIMIENTO DE CTA CTE
        $movimiento = new MovProveedor();
        $movimiento->proveedor      = $request->proveedor;
        $movimiento->tipocomprobante= $request->tipocomprobante;
        $movimiento->idcomprobante  = $pago->id;
        $movimiento->fecha          = $request->fecha;
        $movimiento->concepto       = $concepto;
        $movimiento->nro            = $request->nro;
        $movimiento->debe           = $debe;
        $movimiento->haber          = $haber;
        $movimiento->saldo          = $nuevoSaldo;

        $movimiento->save();

        if ($request->tipocomprobante == 17){
            return redirect()->route('detalleordenpago.index', ['id' => $pago->id]);
        }else{
            return redirect()->route('detallepago.index', ['id' => $pago->id]);
        }
    }

    public function destroy(Request $request){

        $pago       = Pago::find($request->id);
        $proveedor  = $pago->proveedor;
        $pago->delete();

        Compra::where('recibo', '=', $pago->nro)->update(['recibo' => null, 'pagada'=> null, 'fechapago'=> null]);
        MovCheque::where('recibo', '=', $pago->nro)->update(['recibo' => null, 'pagado'=> null, 'fechapago'=> null]);

        // ANULO EL MOVIMIENTO
        $movimiento = MovProveedor::where('idcomprobante', $request->id);
        $movimiento->delete();

        // ACTUALIZO EL SALDO
        $Proveedor  = Proveedor::find($proveedor);
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
        $totalcompra= Compra::where('proveedor', $proveedor)->where('tipocomprobante', '=', 2)->sum('total');
        $totalnotac = Compra::where('proveedor', $proveedor)->where('tipocomprobante', '=', 8)->sum('total');
        $total      = $totalcompra - $totalnotac;

        $pagos      = Pago::orderBy('fecha', 'DESC')->orderBy('nro', 'DESC')->where('proveedor', $proveedor)->get();

        $vistaCompras= view('admin.pagos.detalle', compact('pagos', 'proveedor'))->render();

        return response()->json($vistaCompras);
        
    }

    public function anular($id)
    {
        $pago      = Pago::find($id);
        $proveedor = $pago->proveedor;
        
        Compra::where('recibo', '=', $pago->nro)->update(['recibo' => null, 'pagada'=> null, 'fechapago'=> null]);
        MovCheque::where('recibo', '=', $pago->nro)->update(['recibo' => null, 'pagado'=> null, 'fechapago'=> null]);
        
        // ANULO EL MOVIMIENTO
        $movimiento = MovProveedor::where('idcomprobante', $id);
        $movimiento->delete();
        
        $pago->delete();


        return redirect()->route('pago.pagoProveedor', $proveedor);
    }

}
