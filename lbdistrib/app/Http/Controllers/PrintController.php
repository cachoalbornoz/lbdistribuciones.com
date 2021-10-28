<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\MovContacto,
	App\Models\Contacto,
	App\Models\Venta, 
	App\Models\DetalleVenta, 
	App\Models\Cobro,
    App\Models\DetalleCobro,
    App\Models\MovCheque,
	App\Models\TipoComprobante,
    App\Models\Proveedor,
    App\Models\MovProveedor,
    App\Models\Pago,
    App\Models\Pedido,
    App\Models\Presupuesto,
    App\Models\Presupuestop,
    App\Models\DetallePago, 
    App\Models\Compra,
    App\Models\DetalleCompra,
    App\Models\Producto,
	App\Models\Rubro,
    App\Models\Marca;

use DB, PDF; 

class PrintController extends Controller{

    public function printComprobante($idcomprobante, $tipocomprobante){
        
        $detallecheque  = MovCheque::where('idcomprobante', $idcomprobante)->where('tipocomprobante', $tipocomprobante)->orderBy('id', 'ASC')->get();
        $tipocomprobante= TipoComprobante::where('id',$tipocomprobante)->first();        

        $venta  = array(2, 3, 8);   // Ventas o Devoluciones    2 => PRESUPUESTO, 3 => FACTURA, 8 => NOTA CREDITO
        $pago   = array(9, 16);     // Cobro                    9 => NOTA DEBITO, 16=> RECIBO        

        if(in_array($tipocomprobante->id, $venta)){

            $comprobante= Venta::where('id', $idcomprobante)->first();
            // Enviar todas las ventas 
            $ventas     = null;

        }else{
            if(in_array($tipocomprobante->id, $pago)){

                $comprobante= Cobro::where('id', $idcomprobante)->first();
                // Enviar todas las ventas que se pago con ese recibo
                $ventas     = Venta::where('contacto', $comprobante->contacto)->where('recibo', $comprobante->nro)->orderBy('fecha', 'DESC')->get();


            }else{

                $notification = array(
                'message' => 'La apertura de Cta Cte no genera comprobante', 
                'alert-type' => 'warning');

                return redirect()->to(url()->previous() . '#hash')->with($notification);
            }           
        }

        $pdf = PDF::loadView('admin.print.comprobante', compact('tipocomprobante', 'comprobante', 'detallecheque', 'ventas'));

        return $pdf->stream('comprobante.pdf');
    }


    public function printOrdenPago($id){
        
        $ordenPago  = Pago::find($id);

        $compras    = Compra::where('orden', '=', $ordenPago->nro)->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('admin.print.ordenPago', compact('ordenPago', 'compras'));

        return $pdf->stream('ordenPago.pdf');
    }


    public function printPedido($idcomprobante){
        
        $tipocomprobante= TipoComprobante::where('id', 1)->first();
        $detallecheque  = MovCheque::where('idcomprobante', $idcomprobante)->orderBy('id', 'ASC')->get();
        $comprobante    = Pedido::where('id', $idcomprobante)->first();

        $pdf = PDF::loadView('admin.print.pedido', compact('tipocomprobante', 'comprobante', 'detallecheque'));

        return $pdf->stream('comprobante.pdf');
    }

    public function printPresupuesto($idcomprobante){
        
        $tipocomprobante= TipoComprobante::where('id', 1)->first();
        $detallecheque  = MovCheque::where('idcomprobante', $idcomprobante)->orderBy('id', 'ASC')->get();
        $comprobante    = Presupuesto::where('id', $idcomprobante)->first();

        $pdf = PDF::loadView('admin.print.presupuesto', compact('tipocomprobante', 'comprobante', 'detallecheque'));

        return $pdf->stream('comprobante.pdf');
    }
    
    public function printPresupuestop($idcomprobante){
        
        $tipocomprobante= TipoComprobante::where('id', 2)->first();
        $detallecheque  = MovCheque::where('idcomprobante', $idcomprobante)->orderBy('id', 'ASC')->get();
        $comprobante    = Presupuestop::where('id', $idcomprobante)->first();

        $pdf = PDF::loadView('admin.print.presupuestop', compact('tipocomprobante', 'comprobante', 'detallecheque'));

        return $pdf->stream('comprobante.pdf');
    }


    public function printComprobanteProv($idcomprobante, $tipocomprobante)
    {
        
        $tipocomprobante= TipoComprobante::where('id',$tipocomprobante)->first();

        $compra  = array(2, 3, 8);   // Ventas o Devoluciones    2 => PRESUPUESTO, 3 => FACTURA, 8 => NOTA CREDITO
        $pago   = array(9, 16);     // Cobro                    9 => NOTA DEBITO, 16=> RECIBO

        if(in_array($tipocomprobante->id, $pago)){

            $comprobante= Pago::where('id', $idcomprobante)->first();

        }else{
            if(in_array($tipocomprobante->id, $compra)){

                $comprobante= Compra::where('id', $idcomprobante)->first();

            }else{

                $notification = array(
                'message' => 'No se ha generado comprobante', 
                'alert-type' => 'warning');

                return redirect()->to(url()->previous() . '#hash')->with($notification);
            }           
        }

        $pdf = PDF::loadView('admin.print.comprobanteprov', compact('tipocomprobante', 'comprobante'));

        return $pdf->stream('comprobante.pdf');

    }


    public function printCtaCte($id, $tipo)
    {
        if ($tipo == 1) {
            
            $contacto       = Contacto::where('id',$id)->first();
            $movcontactos   = MovContacto::where('contacto', $id)->orderBy('fecha', 'ASC')->get();
            $pdf            = PDF::loadView('admin.print.ctactecontactos', compact('movcontactos', 'contacto'));
            $apellido       = $contacto->apellido; 

        } else {

            $proveedor      = Proveedor::where('id',$id)->first();
            $movproveedores = MovProveedor::where('proveedor', $id)->orderBy('fecha', 'ASC')->get();
            $pdf            = PDF::loadView('admin.print.ctacteproveedores', compact('movproveedores', 'proveedor'));
            $apellido       = $proveedor->apellido;
            
        }       

        return $pdf->stream('movimientos_'.$apellido.'.pdf');
    }

    public function printCtaCteDeuda($id, $idmax)
    {
        $contacto       = Contacto::where('id',$id)->first();
        if($idmax <> 0){
            $movcontactos    = MovContacto::where('contacto', $id)->whereDate('fecha', '>=', $idmax)->orderBy('id', 'ASC')->get();
        }else{
            $movcontactos    = MovContacto::where('contacto', $id)->orderBy('id', 'ASC')->limit(10)->get();
        }
        $pdf            = PDF::loadView('admin.print.ctactecontactos', compact('movcontactos', 'contacto'));
        $apellido       = $contacto->apellido; 

        return $pdf->stream('movimientos_'.$apellido.'.pdf');
    }

    public function printCtaCteFecha($id, $tipo, $fechad, $fechah)
    {
        if ($tipo == 1) {
            
            $contacto       = Contacto::where('id',$id)->first();
            $movcontactos   = MovContacto::where('contacto', $id)->whereBetween('fecha', [$fechad, $fechah])->orderBy('fecha', 'ASC')->get();
            $pdf            = PDF::loadView('admin.print.ctactecontactos', compact('movcontactos', 'contacto'));
            $apellido       = $contacto->apellido; 

        } else {

            $proveedor      = Proveedor::where('id',$id)->first();
            $movproveedores = MovProveedor::where('proveedor', $id)->orderBy('fecha', 'ASC')->get();
            $pdf            = PDF::loadView('admin.print.ctacteproveedores', compact('movproveedores', 'proveedor'));
            $apellido       = $proveedor->apellido;
            
        }       

        return $pdf->stream('movimientos_'.$apellido.'.pdf');
    }

    public function printProductos(){

        set_time_limit(0);

        $productos  = Producto::orderBy('nombre')->get();
        
        $pdf = PDF::loadView('admin.print.listaproductos', compact('productos'));

        return $pdf->stream('productos.pdf');
    }

    public function printProductosForm(){

        $rubro      = Rubro::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $marca      = Marca::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $proveedor  = Proveedor::orderBy('nombreempresa', 'ASC')->get();
        
        return view('admin.productos.indexPrint', compact('rubro', 'marca', 'proveedor'));
    }

    public function printProductoProveedor($idProveedor){

        $productos = Proveedor::find($idProveedor)->productos()->orderBy('nombre')->get();

        $pdf = PDF::loadView('admin.print.listaproductos', compact('productos'));

        return $pdf->stream('productos.pdf');
    }

    public function printProductoMarcas($marcas){

        $marcas    = explode(',', $marcas);         
        $productos = DB::table('producto as t1')
            ->join('marca as t2', 't1.marca', '=', 't2.id')
            ->join('rubro as t3', 't1.rubro', '=', 't3.id')
            ->select('t1.*', 't2.nombre as nombremarca', 't3.nombre as nombrerubro')
            ->orderBy('t2.nombre', 'ASC')
            ->orderBy('t1.codigobarra', 'ASC')
            ->whereIn('marca', $marcas)
            ->get();
        $marca      = $productos[0]->nombremarca;        

        $pdf = PDF::loadView('admin.print.listaproductos', compact('productos' , 'marca'));
        return $pdf->stream($marca);
    }

    public function printProductoRubros($rubros){
        $rubros     = explode(',', $rubros);         
        $productos = DB::table('producto as t1')
            ->join('rubro as t2', 't1.rubro', '=', 't2.id')
            ->join('marca as t3', 't1.marca', '=', 't3.id')
            ->select('t1.*', 't2.nombre as nombrerubro', 't3.nombre as nombremarca')
            ->orderBy('t3.nombre', 'ASC')
            ->orderBy('t1.codigobarra', 'ASC')
            ->whereIn('rubro', $rubros)
            ->get();

        $rubro  = $productos[0]->nombrerubro;
        $marca  = $productos[0]->nombremarca;
        
        $pdf = PDF::loadView('admin.print.listaproductos', compact('productos' , 'rubro'));
        return $pdf->stream($rubro);
    }

    public function printProductoRubroMarca(Request $request){

        $rubros = explode(',', $request->rubros);
        $marcas = explode(',', $request->marcas);
        
        $productos = DB::table('producto as t1')
        ->join('rubro as t2', 't1.rubro', '=', 't2.id')
        ->join('marca as t3', 't1.marca', '=', 't3.id')
        ->select('t1.*', 't2.nombre as nombrerubro', 't3.nombre as nombremarca')
        ->whereIn('rubro', $rubros)
        ->whereIn('marca', $marcas)
        ->orderBy('t2.nombre', 'ASC')
        ->orderBy('t1.codigobarra', 'ASC')
        ->get();

        $rubro  = $productos[0]->nombrerubro;
        $marca  = $productos[0]->nombremarca;

        $pdf = PDF::loadView('admin.print.listaproductos', compact('productos' , 'rubro'));
        return $pdf->stream($rubro);
    }
}
