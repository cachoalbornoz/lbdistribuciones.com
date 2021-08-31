<?php

namespace App\Http\Controllers;

use App\Models\Contacto,
    App\Models\Cobro,
    App\Models\Venta,
    App\Models\MovContacto,
    App\Models\Ciudad,
    App\Models\Vendedor,
    App\Models\TipoResponsable;

use Caffeinated\Shinobi\Models\Role,
    Caffeinated\Shinobi\Models\Permission;
use Auth;
use Session;

use Illuminate\Http\Request;
use App\Http\Requests\ContactoRequest;


class ContactoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:contacto.index')->only('index');
        $this->middleware('permission:contacto.create')->only(['create', 'store']);
        $this->middleware('permission:contacto.edit')->only(['edit', 'update']);
        $this->middleware('permission:contacto.destroy')->only('destroy');
    }

    public function index(){
        
        if( Auth::user()->isRole( 'vendedor' ) ) {
            $vendedor   = Auth::user()->vendedor->id;
            $contactos  = Contacto::where('vendedor', $vendedor)->orderBy('nombreempresa', 'ASC')->get();
        }else{

            $contactos = Contacto::orderBy('nombreempresa', 'ASC')->get();
        }

        return view('admin.contactos.index', compact('contactos'));

    }


    public function create(){
        
        $vendedores     = Vendedor::get();
        $ciudad         = Ciudad::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $tipoResponsable= TipoResponsable::orderBy('condicion', 'ASC')->pluck('condicion', 'id');

        return view('admin.contactos.create', compact('ciudad','tipoResponsable', 'vendedores'));
    }


    public function store(ContactoRequest $request)
    {
        $contacto   = new Contacto($request->all());
        $contacto->save();

        $movimiento = new MovContacto();

        $movimiento->contacto       = $contacto->id;
        $movimiento->tipocomprobante= 10;
        $movimiento->idcomprobante  = 0;
        $movimiento->nro            = 0;
        $movimiento->fecha          = date('Y-m-d',time());
        $movimiento->concepto       = 'APERTURA DE CTA CTE';
        $movimiento->debe           = 0;
        $movimiento->haber          = 0;
        $movimiento->saldo          = $contacto->saldo;
        $movimiento->save();

        $notification = array(
            'message' => $contacto->nombreempresa .' se ha guardado !',
            'alert-type' => 'success');

        return redirect()->route('contacto.index')->with($notification);
    }


    public function edit($id)
    {
        $contacto       = Contacto::find($id);
        $vendedores     = Vendedor::get();
        $ciudad         = Ciudad::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $tiporesponsable= TipoResponsable::orderBy('condicion', 'ASC')->pluck('condicion', 'id');

        return view('admin.contactos.edit', compact('contacto', 'ciudad', 'tiporesponsable', 'vendedores'));
    }


    public function update(Request $request, $id)
    {
        $contacto = contacto::find($id);
        $contacto->fill($request->all());
        $contacto->save();

        $notification = array(
            'message' => $contacto->nombreempresa .' se ha actualizado !',
            'alert-type' => 'success');

        return redirect()->route('contacto.edit', $contacto->id)->with($notification);
    }

    public function show(Contacto $contacto)
    {
        return view('admin.contactos.show', compact('contacto'));
    }

    public function destroy(Request $request){

        $contactos = Contacto::where("id", $request->id)->delete();

        return response()->json();
    }

    public function vendedor(Request $request){

        if ($request->ajax()) {

            $vendedor   = Contacto::where("id", $request->contacto)->get(['vendedor']);

            return response()->json($vendedor);

        }
        
    }

    public function ctasctes(Request $request){

        $contactos  = Contacto::get();

        foreach($contactos as $contacto){

            // VER TODOS LOS PAGOS REALIZADOS

            $cobro      = Cobro::where('contacto', '=', $contacto->id)->where('tipocomprobante', '=', 16)->sum('total');
            $notadebito = Cobro::where('contacto', '=', $contacto->id)->where('tipocomprobante', '=',  9)->sum('total');

            // VER TODAS LAS NOTAS CREDITOS REALIZADAS

            $ventas     = Venta::where('contacto', '=', $contacto->id)->where('tipocomprobante', '=', 2)-> whereNull('pagada')->sum('total');
            $notacredito= Venta::where('contacto', '=', $contacto->id)->where('tipocomprobante', '=', 8)->sum('total');

            $totalcobro = $cobro + $notacredito - $notadebito;

            // ACTUALIZA SALDO CONTACTO 

            $contacto->saldo = $ventas - $totalcobro;

            // ACTUALIZA LAS FACTURAS PENDIENTES DE PAGO

            $facturas   = Venta::
                where('contacto', '=', $contacto->id)->
                where('tipocomprobante', '=', 2)->
                whereNull('pagada')->
                orderBy('fecha','ASC')->get();

            foreach($facturas as $factura){

                if($totalcobro < $factura->total){
                    
                    // Si lo pagado más lo que tenía es MENOR, debe finalizar y guardar el nuevo remanente 
                    $contacto->remanente = $totalcobro;
                    break;

                }else{

                    if($totalcobro == $factura->total){

                        // Si lo pagado más lo que tenía es IGUAL debe poner pagada la factura, remanente = 0 y finalizar 
                        $factura->pagada    = 1;
                        $factura->fechapago = date('Y-m-d',time());
                        $factura->recibo    = 0;
                        $factura->save();

                        $contacto->remanente= 0;

                        break;

                    }else{

                        // Si lo pagado más lo que tenía es MAYOR debe poner pagada la factura 
                        $factura->pagada    = 1;
                        $factura->fechapago = date('Y-m-d',time());
                        $factura->recibo    = 0;
                        $factura->save();

                        $totalcobro = $totalcobro - $factura->total;

                        $contacto->remanente = $totalcobro;

                    }
                }

            }

            $contacto->save();

        }
        
        $notification = array(
            'message' => 'Ctas ctes actualizadas  !',
            'alert-type' => 'success');


        return redirect()->route('contacto.index')->with($notification);
    }


}
