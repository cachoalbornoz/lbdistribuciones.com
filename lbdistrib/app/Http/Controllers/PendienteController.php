<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pendiente;

class PendienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pendiente.index')->only('index');
        $this->middleware('permission:pendiente.create')->only(['create', 'store']);
        $this->middleware('permission:pendiente.edit')->only(['edit', 'update']);
        $this->middleware('permission:pendiente.destroy')->only('destroy');
    }

    public function index()
    {
        $pendientes = Pendiente::orderBy('id', 'DESC')->get();

        return view('admin.pendientes.index', compact('pendientes'));
    }

    public function destroy(Request $request){

        Pendiente::where("id", $request->id)->delete();

        return response()->json();
    }
}
