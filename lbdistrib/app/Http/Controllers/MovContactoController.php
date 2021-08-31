<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MovContacto,
    App\Models\Venta,
    App\Models\Cobro,
    App\Models\Contacto;

use Carbon\Carbon;

use DB;

class MovContactoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:movcontacto.destroy')->only('destroy');
    }

    public function index($id){
        
        $movcontactos    = MovContacto::where('contacto', $id)
            ->orderBy('fecha', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();
        $contacto        = Contacto::where('id', $id)->first();

        return  view('admin.movcontactos.index', compact('contacto', 'movcontactos'));
    }

    public function deuda($id){ 

        $contacto       = Contacto::where('id', $id)->first();

        $ventas         = Venta::where('contacto', '=', $id)->where('tipocomprobante', '=', 2)->whereNull('pagada')->orderBy('fecha', 'ASC')->get();

        $tventa         = Venta::where('contacto', '=', $id)->where('tipocomprobante', '=', 2)->whereNull('pagada')->sum('total');
        $ncredito       = Venta::where('contacto', '=', $id)->where('tipocomprobante', '=', 8)->whereNull('pagada')->sum('total');
        $ndebito        = Cobro::where('contacto', '=', $id)->where('tipocomprobante', '=', 9)->sum('total');
        $cobro          = Cobro::where('contacto', '=', $id)->where('tipocomprobante', '=', 16)->sum('total');

        $totalacobrar   = $tventa-$ncredito-$cobro+$ndebito;

        return  view('admin.movcontactos.deuda', compact('contacto', 'ventas', 'totalacobrar', 'tventa', 'ncredito', 'cobro', 'ndebito'));
    }

    public function buscar(Request $request)
    {
        if ($request->ajax()) {

            if ($request->quitar) {
                $movcontactos   = MovContacto::where('contacto', $request->contacto)
                ->orderBy('fecha', 'DESC')
                ->orderBy('id', 'DESC')
                ->get();
            } else {
                $movcontactos   = MovContacto::
                    where('contacto', $request->contacto)->
                    buscarfechas($request->desde, $request->hasta)
                    ->orderBy('fecha', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
            }

            $view   = view('admin.movcontactos.detalle', compact('movcontactos'))->render();

            return response()->json($view);
        }
    }

    public function destroy(Request $request)
    {
        MovContacto::where("id",$request->id)->delete();
        return response()->json();
    }
}
