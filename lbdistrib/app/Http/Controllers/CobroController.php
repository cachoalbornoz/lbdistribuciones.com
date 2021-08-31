<?php

namespace App\Http\Controllers;

use App\Models\Cobro,
    App\Models\DetalleCobro,
    App\Models\Contacto,
    App\Models\TipoComprobante,
    App\Models\Vendedor,
    App\Models\TipoFormapago,
    App\Models\MovContacto,
    App\Models\Venta;

use Illuminate\Http\Request;
use App\Http\Requests\CobroRequest;

use Carbon\Carbon;



class CobroController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cobro.index')->only('index');
        $this->middleware('permission:cobro.create')->only(['create', 'store']);
        $this->middleware('permission:cobro.edit')->only(['edit', 'update']);
        $this->middleware('permission:cobro.destroy')->only('destroy');
    }

    public function index()
    {
        $cobros     = Cobro::orderBy('fecha', 'DESC')->paginate(50);
        $total      = Cobro::all()->sum('total');
        return view('admin.cobros.index', compact('cobros', 'total'));
    }

    public function cobroContacto($id){

        $contacto   = Contacto::find($id);
        $cobros     = Cobro::where('contacto', $id)->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')->paginate(50);

        // OBTENER TOTAL COBROS
        $totalcobro = Cobro::where('contacto', $id)->where('tipocomprobante', '=', 16)->sum('total');
        // OBTENER TOTAL NOTA DEDITO
        $totalnotad = Cobro::where('contacto', $id)->where('tipocomprobante', '=', 9)->sum('total');
        // CALCULAR TOTAL 
        $total      = $totalcobro - $totalnotad;
        
        return view('admin.cobros.index', compact('id', 'cobros', 'contacto', 'total'));
    }

    public function create($id)
    {
        $Cobro      = Cobro::orderBy('nro', 'desc')->first();
        $nroCobro   = isset($Cobro) ? $Cobro->nro + 1 : 1;

        if($id){

            $contacto   = Contacto::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
            ->where('id', $id)
            ->pluck('nombreCompleto', 'id');

        }else{

            $contacto   = Contacto::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
            ->orderBy('nombreEmpresa','ASC')
            ->pluck('nombreCompleto', 'id');
        }

        $tipoComprobante= TipoComprobante::where('id', '=' ,9)->orWhere('id', '=' ,16)
            ->orderBy('id','DESC')
            ->pluck('comprobante', 'id');

        return view('admin.cobros.create', compact('id', 'contacto', 'tipoComprobante', 'nroCobro'));

    }

    public function show(Request $request)
    {
        if ($request->quitar) {
            $cobros = Cobro::orderBy('fecha', 'DESC')->paginate(50);
        } else {
            $cobros    = Cobro::
                buscarfechas($request->desde, $request->hasta)->
                orderBy('fecha', 'DESC')->paginate(50);
            $total      = Cobro::buscarfechas($request->desde, $request->hasta)->sum('total');
        }

        return view('admin.cobros.index', compact('cobros', 'total'));        
    }
 
    public function buscar(Request $request)
    {
        if ($request->ajax()) {

            if ($request->quitar) {
                $cobros = Cobro::buscarcontacto($request->contacto)->orderBy('fecha', 'DESC')->paginate(50);
                $total  = Cobro::buscarcontacto($request->contacto)->sum('total'); 

            } else {
                $cobros    = Cobro::
                    buscarcontacto($request->contacto)->
                    buscarfechas($request->desde, $request->hasta)->
                    orderBy('fecha', 'DESC')->paginate(50);

                $total      = Cobro::
                    buscarcontacto($request->contacto)->
                    buscarfechas($request->desde, $request->hasta)->
                    sum('total');    
            }

            $view = view('admin.cobros.detalle', compact('cobros', 'total'))->render();

            return response()->json($view);
        }
    }

    public function store(CobroRequest $request){       

        $concepto   = ($request->tipocomprobante == 16)?'RECIBO':'NOTA DEBITO';
        
        // ASIENTO EL COBRO
        $cobro = new Cobro($request->all());
        $cobro->save();
        
        /////// AGREGA MOVIMIENTO DE CTA CTE
        $movimiento = new MovContacto();
        $movimiento->contacto       = $request->contacto;
        $movimiento->tipocomprobante= $request->tipocomprobante;
        $movimiento->idcomprobante  = $cobro->id;
        $movimiento->fecha          = $request->fecha;
        $movimiento->concepto       = $concepto;
        $movimiento->nro            = $request->nro;
        $movimiento->debe           = 0;
        $movimiento->haber          = 0;
        $movimiento->saldo          = 0;
        $movimiento->save();

        return redirect()->route('detallecobro.index', ['id' => $cobro->id]);
    }

    public function destroy(Request $request){

        $cobro      = Cobro::find($request->id);
        $contacto   = $cobro->contacto;
        $cobro->delete();

        // ANULO LA INPUTACION DEL RECIBO
        Venta::where('recibo', '=', $cobro->nro)->update(['recibo' => null, 'pagada'=> null, 'fechapago'=> null]);

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

        $cobros     = Cobro::where('contacto', $contacto)->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')->paginate(50);
        $totalcobro = Cobro::where('contacto', $contacto)->where('tipocomprobante', '=', 16)->sum('total');
        $totalnotad = Cobro::where('contacto', $contacto)->where('tipocomprobante', '=', 9)->sum('total');
        $total      = $totalcobro - $totalnotad;

        $vistaCobros= view('admin.cobros.detalle', compact('cobros', 'total', 'contacto'))->render();

        return response()->json($vistaCobros);
    }

    public function anular($id){

        $cobro      = Cobro::find($id);
        $contacto   = $cobro->contacto;
        $total      = $cobro->total;
        $comprobante= $cobro->tipocomprobante;
        $cobro->delete();

        // Anulo la inputacion del RECIBO
        Venta::where('recibo', '=', $cobro->nro)->update(['recibo' => null, 'pagada'=> null, 'fechapago'=> null]);

        // ACTUALIZO EL SALDO
        $contacto   = Contacto::find($contacto);
        $saldo      = $contacto->saldo;

        if ($comprobante == 16) {   // RECIBO
            $saldo  = $saldo + $total;
        } else {                   // NOTA DEBITO
            $saldo  = $saldo - $total;
        }

        $contacto->saldo = $saldo ;
        $contacto->save();

        // ANULO EL MOVIMIENTO
        $movimiento = MovContacto::where('idcomprobante', $id);
        $movimiento->delete();

        return redirect()->route('cobro.cobroContacto', ['id' => $contacto->id]);
    }


}
