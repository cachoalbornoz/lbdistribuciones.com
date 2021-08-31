<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Carbon;


use App\Models\Actualizacion,
    App\Models\Rubro,
    App\Models\Marca,
    App\Models\Producto,
    App\Models\Proveedor;

class ActualizacionController extends Controller
{
    public function index()
    {

        $actualizaciones = Actualizacion::orderBy('id', 'DESC')->get();

        return view('admin.actualizacion.index', compact('actualizaciones'));
    }

    public function parametro()
    {

        $rubro      = Rubro::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $marca      = Marca::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $proveedor  = Proveedor::selectRaw('id, CONCAT(nombreEmpresa," - ",apellido," ",nombres) as nombreCompleto')->orderBy('nombreEmpresa', 'ASC')->pluck('nombreCompleto', 'id');

        return view('admin.actualizacion.parametros', compact('rubro', 'proveedor', 'marca'));
    }


    public function destroy(Request $request)
    {

        Actualizacion::where("id", $request->id)->delete();

        return response()->json();
    }

    public function buscar(Request $request)
    {

        if ($request->ajax()) {

            if ($request->quitar) {

                $productos  = Producto::orderBy('nombre', 'ASC')->get();
            } else {

                $productos  = Producto::buscarmarca($request->marca)->buscarrubro($request->rubro)->orderBy('nombre', 'ASC')->get();
            }

            $view      = view('admin.actualizacion.detalleproducto', compact('productos'))->render();

            return response()->json($view);
        }
    }

    public function actualizar(Request $request)
    {

        if ($request->ajax()) {

            $productos  = Producto::buscarmarca($request->marca)->buscarrubro($request->rubro)->orderBy('nombre', 'ASC')->get();

            foreach ($productos as $producto) {

                if ($request->preciolista) {
                    $producto->preciolista  = $producto->preciolista * $request->preciolista;
                }

                if ($request->margen) {
                    $producto->margen       = $request->margen;
                }

                if ($request->flete) {
                    $producto->flete        = $request->flete;
                }

                if ($request->bonificacion) {
                    $producto->bonificacion = $request->bonificacion;
                }

                $producto->precioventa      = $producto->preciolista * $producto->margen * $producto->flete * $producto->bonificacion;

                $producto->save();
            }

            $productos  = Producto::buscarmarca($request->marca)->buscarrubro($request->rubro)->orderBy('nombre', 'ASC')->get();

            if ($request->marca) {
                $marca     = $request->marca;
            } else {
                $marca = NULL;
            }

            if ($request->rubro) {
                $rubro     = $request->rubro;
            } else {
                $rubro = NULL;
            }

            if ($request->preciolista) {
                $preciolista = $request->preciolista;
            } else {
                $preciolista = NULL;
            }

            if ($request->margen) {
                $margen     = $request->margen;
            } else {
                $margen = NULL;
            }

            if ($request->flete) {
                $flete      = $request->flete;
            } else {
                $flete  = NULL;
            }

            if ($request->bonificacion) {
                $bonificacion = $request->bonificacion;
            } else {
                $bonificacion = NULL;
            }

            $registros      = $productos->count('id');

            $actualizacion  = new Actualizacion();

            $actualizacion->preciolista     = $preciolista;
            $actualizacion->rubro           = $rubro;
            $actualizacion->marca           = $marca;
            $actualizacion->bonificacion    = $bonificacion;
            $actualizacion->flete           = $flete;
            $actualizacion->margen          = $margen;
            $actualizacion->registros       = $registros;
            $actualizacion->usuario         = Auth::user()->id;

            $actualizacion->save();

            return redirect()->route('actualizacion.index');
        }
    }

    public function show()
    {
    }

    public function reversar($id)
    {
        $actualizacion  = Actualizacion::find($id);

        $preciolista    = $actualizacion->preciolista;
        $rubro          = $actualizacion->rubro;
        $marca          = $actualizacion->marca;
        $bonificacion   = isset($actualizacion->bonificacion) ? $actualizacion->bonificacion : 1;
        $flete          = isset($actualizacion->flete) ? $actualizacion->flete : 1;
        $margen         = isset($actualizacion->margen) ? $actualizacion->margen : 1;

        // OBTENER INDICE ACTUALIZACION PARA REVERSAR
        $indice         = 1 / ($preciolista * $bonificacion * $flete * $margen);

        $productos      = Producto::buscarmarca($marca)->buscarrubro($rubro)->orderBy('nombre', 'ASC')->get();
        $registros      = $productos->count('id');

        foreach ($productos as $producto) {

            $producto->bonificacion     = isset($actualizacion->bonificacion) ? $actualizacion->bonificacion : $producto->bonificacion;
            $producto->flete            = isset($actualizacion->flete) ? $actualizacion->flete : $producto->flete;
            $producto->margen           = isset($actualizacion->margen) ? $actualizacion->margen : $producto->margen;

            $producto->preciolista      = $producto->preciolista * $indice;
            $producto->precioventa      = $producto->preciolista * $producto->margen * $producto->flete * $producto->bonificacion;

            $producto->save();
        }


        $productos      = Producto::buscarmarca($marca)->buscarrubro($rubro)->orderBy('nombre', 'ASC')->get();


        $preciolista    = isset($actualizacion->preciolista) ? $actualizacion->preciolista : null;
        $rubro          = isset($actualizacion->rubro) ? $actualizacion->rubro : null;
        $marca          = isset($actualizacion->marca) ? $actualizacion->marca : null;
        $bonificacion   = isset($actualizacion->bonificacion) ? $actualizacion->bonificacion : null;
        $flete          = isset($actualizacion->flete) ? $actualizacion->flete : null;
        $margen         = isset($actualizacion->margen) ? $actualizacion->margen : null;

        $actualizacion  = new Actualizacion();

        $actualizacion->preciolista     = $preciolista;
        $actualizacion->rubro           = $rubro;
        $actualizacion->marca           = $marca;
        $actualizacion->bonificacion    = $bonificacion;
        $actualizacion->flete           = $flete;
        $actualizacion->margen          = $margen;
        $actualizacion->registros       = $registros;
        $actualizacion->reversa         = 1;
        $actualizacion->usuario         = Auth::user()->id;

        $actualizacion->save();

        return redirect()->route('actualizacion.index');
    }
}