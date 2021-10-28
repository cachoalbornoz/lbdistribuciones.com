<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PresupuestopRequest;

use App\Models\Presupuestop;
use App\Models\Proveedor;
use App\Models\TipoComprobante;
use App\Models\TipoFormapago;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Auth;

class PresupuestopController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:presupuesto.index')->only('index');
        $this->middleware('permission:presupuesto.facturado')->only('index');
        $this->middleware('permission:presupuesto.create')->only(['create', 'store']);
        $this->middleware('permission:presupuesto.edit')->only(['edit', 'update']);
        $this->middleware('permission:presupuesto.destroy')->only('destroy');
    }

    public function index()
    {
        $presupuestos   = Presupuestop::activo()->orderBy('id', 'DESC')->get();
        return view('admin.presupuestosp.index', compact('presupuestos'));
    }

    public function create()
    {
        $proveedor      = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')->orderBy('nombreEmpresa', 'ASC')->pluck('nombreCompleto', 'id');
        $tipocomprobante= TipoComprobante::where('id', '=', 2)->orderBy('id', 'DESC')->pluck('comprobante', 'id');
        $formapago      = TipoFormapago::orderBy('id', 'DESC')->pluck('forma', 'id');

        return view('admin.presupuestosp.create', compact('proveedor', 'tipocomprobante', 'formapago'));
    }

    public function store(PresupuestopRequest $request)
    {
        $presupuesto = new Presupuestop($request->all());
        $presupuesto->save();

        return redirect()->route('detallepresupuestop.index', ['id' => $presupuesto->id]);
    }

    public function show($id)
    {
        $presupuesto = Presupuestop::find($id);
        return redirect()->route('detallepresupuestop.index', ['id' => $presupuesto->id]);
    }

    public function edit($id)
    {
        $presupuesto    = Presupuestop::find($id);
        $proveedor      = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')->orderBy('nombreEmpresa', 'ASC')->pluck('nombreCompleto', 'id');
        $tipocomprobante= TipoComprobante::where('id', '=', 2)->orderBy('id', 'DESC')->pluck('comprobante', 'id');
        $formapago      = TipoFormapago::orderBy('id', 'DESC')->pluck('forma', 'id');

        return view('admin.presupuestosp.edit', compact('presupuesto','proveedor', 'tipocomprobante', 'formapago' ));
    }

    public function update(Request $request)
    {
        $presupuesto = Presupuestop::find($request->id);
        $presupuesto->fill($request->all());
        $presupuesto->save();
        return redirect()->route('presupuestop.index');
    }


    public function destroy(Request $request)
    {
        $presupuesto      = Presupuestop::where("id", $request->id)->delete();
        return response()->json();
    }

    public function descartar($id)
    {
        $presupuesto      = Presupuestop::where("id", $id)->delete();
        return redirect()->route('presupuestop.index');
    }
}