<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Http\Requests\PedidoRequest;;

use App\Models\Pedido,
    App\Models\Contacto,
    App\Models\TipoComprobante,
    App\Models\Vendedor,
    App\Models\TipoFormapago;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Auth;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pedido.index')->only('index');
        $this->middleware('permission:pedido.facturado')->only('index');
        $this->middleware('permission:pedido.create')->only(['create', 'store']);
        $this->middleware('permission:pedido.edit')->only(['edit', 'update']);
        $this->middleware('permission:pedido.destroy')->only('destroy');
    }

    public function index()
    {
        if (Auth::user()->isRole('vendedor')) {
            $vendedor   = Auth::user()->vendedor->id;
            $pedidos    = Pedido::activo()->where('vendedor', $vendedor)->orderBy('id', 'DESC')->get();
        } else {

            $pedidos    = Pedido::activo()->orderBy('id', 'DESC')->get();
        }

        return view('admin.pedidos.index', compact('pedidos'));
    }


    public function facturado()
    {
        if (Auth::user()->isRole('vendedor')) {
            $vendedor   = Auth::user()->vendedor->id;
            $pedidos    = Pedido::facturado()->where('vendedor', $vendedor)->orderBy('updated_at', 'DESC')->get();
        } else {

            $pedidos    = Pedido::facturado()->orderBy('updated_at', 'DESC')->get();
        }

        return view('admin.pedidos.facturados', compact('pedidos'));
    }

    public function create()
    {
        $contacto       = Contacto::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')->orderBy('nombreEmpresa', 'ASC')->pluck('nombreCompleto', 'id');
        $tipocomprobante = TipoComprobante::where('id', '=', 1)->orderBy('id', 'DESC')->pluck('comprobante', 'id');
        $vendedor       = Vendedor::selectRaw('id, CONCAT(apellido," ",nombres) as nombreCompleto')->orderBy('apellido', 'ASC')->pluck('nombreCompleto', 'id');
        $formapago      = TipoFormapago::orderBy('id', 'DESC')->pluck('forma', 'id');

        return view('admin.pedidos.create', compact('contacto', 'tipocomprobante', 'vendedor', 'formapago'));
    }

    public function store(PedidoRequest $request)
    {
        $pedido   = Pedido::activo()->where("contacto", $request->contacto)->first();

        if (!isset($pedido->id)) {

            $pedido = new Pedido($request->all());
            $pedido->save();
        }



        return redirect()->route('detallepedido.index', ['id' => $pedido->id]);
    }

    public function edit($id)
    {
        $pedido = Pedido::find($id);

        $contacto       = Contacto::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')->orderBy('nombreEmpresa', 'ASC')->pluck('nombreCompleto', 'id');
        $tipocomprobante = TipoComprobante::where('id', '=', 1)->orderBy('id', 'DESC')->pluck('comprobante', 'id');
        $vendedor       = Vendedor::selectRaw('id, CONCAT(apellido," ",nombres) as nombreCompleto')->orderBy('apellido', 'ASC')->pluck('nombreCompleto', 'id');
        $formapago      = TipoFormapago::orderBy('id', 'DESC')->pluck('forma', 'id');

        return view('admin.pedidos.edit', compact('pedido', 'contacto', 'tipocomprobante', 'vendedor', 'formapago'));
    }

    public function update(Request $request)
    {
        $pedido = Pedido::find($request->pedido);
        $pedido->fill($request->all());
        $pedido->save();

        return redirect()->route('pedido.index');
    }


    public function destroy(Request $request)
    {

        $pedido      = Pedido::where("id", $request->id)->delete();
        return response()->json();
    }

    public function descartar($id)
    {

        $pedido      = Pedido::where("id", $id)->delete();
        return redirect()->route('pedido.index');
    }
}