<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Dolar,
    App\Models\Producto;

class DolarController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:dolar.edit')->only(['edit', 'update']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 1)
    {
        $dolar = Dolar::find($id);

        return view('admin.dolar.edit', compact('dolar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dolar = Dolar::find($id);

        $dolar->valoranterior   = $dolar->valoractual;
        $dolar->valoractual     = $request->valoractual;
        $dolar->diferencia      = ($dolar->valoractual - $dolar->valoranterior) / $dolar->valoranterior ;
        $dolar->save();

        // ACTUALIZA PRODUCTOS

        $productos  = Producto::where('actdolar', 1)->get() ;

        foreach ($productos as $producto) {
            
            $difdolar               = $producto->preciolista * ( 1 + $dolar->diferencia );
            $producto->precioventa  = $difdolar * $producto->bonificacion * $producto->flete * $producto->margen;
            $producto->save();
        }

        //

        $notification = array(
            'message' => 'Valor del dolar actualizado !',
            'alert-type' => 'success');


        return redirect()->route('actualizacion.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
