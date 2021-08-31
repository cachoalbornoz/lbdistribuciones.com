<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChequeRequest;

use App\Models\Contacto, App\Models\MovCheque, App\Models\Banco;

use View ;

class ChequeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cheque.index')->only('index');
        $this->middleware('permission:cheque.create')->only(['create', 'store']);
        $this->middleware('permission:cheque.edit')->only(['edit', 'update']);
        $this->middleware('permission:cheque.destroy')->only('destroy');
    }


    public function index()
    {
        $cheques    = MovCheque::orderBy('fechacobro', 'DESC')->get();
        $banco      = Banco::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        return view('admin.movcheques.index', compact('cheques', 'banco'));
    }

    public function buscar(Request $request)
    {
        if ($request->ajax()) {

            if ($request->quitar) {
                $cheques    = MovCheque::orderBy('fechacobro', 'ASC')->get();
            } else {
                $cheques    = MovCheque::
                buscarbanco($request->banco)->
                buscarfechas($request->desde, $request->hasta)->
                orderBy('fechacobro', 'ASC')->get();
            }

            $view      = view('admin.movcheques.detalle', compact('cheques'))->render();

            return response()->json($view);
        }
    }

    public function create()
    {
        $contacto   = Contacto::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
            ->orderBy('nombreEmpresa','ASC')
            ->pluck('nombreCompleto', 'id');
        $banco      = Banco::orderBy('nombre', 'ASC')->pluck('nombre', 'id');

        return view('admin.movcheques.create', compact('contacto', 'banco'));
    }


    public function store(ChequeRequest $request){

        $cheque        = new MovCheque($request->all());

        if($request->fechapago){
            $cheque->fechapago = $request->fechapago;    
        }else{
            $cheque->fechapago = null;
        }



        if ($request->cobrado) {
            $cheque->cobrado = 1;
        } else {
            $cheque->cobrado = 0;
        };
        
        $cheque->save();

        return redirect()->route('cheque.index');

    }


    public function edit($id)
    {
        $contacto   = Contacto::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')
            ->orderBy('nombreEmpresa','ASC')
            ->pluck('nombreCompleto', 'id');
        $cheque     = MovCheque::find($id);
        $banco      = Banco::orderBy('nombre', 'ASC')->pluck('nombre', 'id');

        return view('admin.movcheques.edit', compact('contacto', 'cheque', 'banco'));
    }

    public function update(Request $request, $id)
    {
        $cheque = MovCheque::find($id);
        $cheque->fill($request->all());

        if ($request->cobrado) {
            $cheque->cobrado = 1;
        } else {
            $cheque->cobrado = 0;
        };

        $cheque->save();

        return redirect()->route('cheque.index');
    }

    public function destroy(Request $request)
    {
        $cheques = MovCheque::where("id", $request->id)->delete();
        return response()->json();
    }
}
