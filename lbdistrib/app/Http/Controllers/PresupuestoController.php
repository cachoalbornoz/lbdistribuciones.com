<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresupuestoRequest;
use App\Models\Contacto;
use App\Models\DetallePresupuesto;
use App\Models\Pendiente;
use App\Models\Presupuesto;
use App\Models\TipoComprobante;
use App\Models\TipoFormapago;
use App\Models\Vendedor;
use Auth;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
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
        if (Auth::user()->isRole('vendedor')) {
            $vendedor = Auth::user()->vendedor->id;
            $presupuestos = Presupuesto::activo()->where('vendedor', $vendedor)->orderBy('id', 'DESC')->get();
        } else {
            $presupuestos = Presupuesto::activo()->orderBy('id', 'DESC')->get();
        }

        return view('admin.presupuestos.index', compact('presupuestos'));
    }

    public function facturado()
    {
        if (Auth::user()->isRole('vendedor')) {
            $vendedor = Auth::user()->vendedor->id;
            $presupuestos = Presupuesto::facturado()->where('vendedor', $vendedor)->orderBy('id', 'DESC')->paginate(10);
        } else {
            $presupuestos = Presupuesto::facturado()->orderBy('id', 'DESC')->paginate(10);
        }

        return view('admin.presupuestos.facturados', compact('presupuestos'));
    }

    public function create()
    {
        $contacto = Contacto::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')->orderBy('nombreEmpresa', 'ASC')->pluck('nombreCompleto', 'id');
        $tipocomprobante = TipoComprobante::where('id', '=', 1)->orderBy('id', 'DESC')->pluck('comprobante', 'id');
        $vendedor = Vendedor::selectRaw('id, CONCAT(apellido," ",nombres) as nombreCompleto')->orderBy('apellido', 'ASC')->pluck('nombreCompleto', 'id');
        $formapago = TipoFormapago::orderBy('id', 'DESC')->pluck('forma', 'id');

        return view('admin.presupuestos.create', compact('contacto', 'tipocomprobante', 'vendedor', 'formapago'));
    }

    public function store(PresupuestoRequest $request)
    {
        $presupuesto = new Presupuesto($request->all());
        $presupuesto->save();

        return redirect()->route('detallepresupuesto.index', ['id' => $presupuesto->id]);
    }

    public function edit($id)
    {
        $presupuesto = Presupuesto::find($id);

        return redirect()->route('detallepresupuesto.index', ['id' => $presupuesto->id]);
    }

    public function editPendiente($id)
    {
        // Obtener la info de un pendiente
        $pendiente = Pendiente::find($id);

        // Crear Presupuesto
        $presupuesto = Presupuesto::create([
            'tipocomprobante' => 1,
            'vendedor' => 1,
            'contacto' => $pendiente->contacto,
            'fecha' => date(now()),
            'formapago' => 2,
        ]);

        // Obtener la info de todos los pendientes
        $detallePendiente = Pendiente::where('contacto', '=', $pendiente->contacto)->get();

        foreach ($detallePendiente as $pendiente) {

            DetallePresupuesto::create([
                'producto' => $pendiente->producto,
                'presupuesto' => $presupuesto->id,
                'precio' => $pendiente->precio,
                'cantidad' => $pendiente->cantidad,
                'descuento' => $pendiente->descuento,
                'subtotal' => $pendiente->subtotal,
            ]);
        }

        // Borrar los movimientos pendientes
        Pendiente::where('contacto', '=', $pendiente->contacto)->delete();

        return redirect()->route('detallepresupuesto.index', ['id' => $presupuesto->id]);
    }

    public function update(Request $request)
    {
        $presupuesto = Presupuesto::find($request->id);

        $presupuesto->fill($request->all());
        $presupuesto->save();

        return response()->json($presupuesto);
    }

    public function destroy(Request $request)
    {
        $presupuesto = Presupuesto::where("id", $request->id)->delete();
        return response()->json();
    }

    public function descartar($id)
    {
        $presupuesto = Presupuesto::where("id", $id)->delete();
        return redirect()->route('presupuesto.index');
    }
}
