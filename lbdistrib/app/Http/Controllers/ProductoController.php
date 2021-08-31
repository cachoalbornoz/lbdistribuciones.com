<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;

use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Rubro;
use App\Models\Marca;
use App\Models\DetalleVenta;
use App\Models\Venta;

use DB;
use Image;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:producto.index')->only('index');
        $this->middleware('permission:producto.create')->only(['create', 'store']);
        $this->middleware('permission:producto.edit')->only(['edit', 'update']);
        $this->middleware('permission:producto.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $producto    = Producto::all();

            if ($producto) {
                return Datatables::of($producto)
                    ->editColumn('id', function ($producto) {

                        return (isset($producto->codigobarra)) ? '<a href= "' . route('producto.edit', $producto->id) . '">' . $producto->id . '</a>' : null;
                    })
                    ->editColumn('codigobarra', function ($producto) {
                        return (isset($producto->codigobarra)) ? $producto->codigobarra : null;
                    })
                    ->editColumn('marca', function ($producto) {
                        return (isset($producto->marca)) ? $producto->Marca->nombre : null;
                    })
                    ->editColumn('rubro', function ($producto) {
                        return (isset($producto->rubro)) ? $producto->Rubro->nombre : null;
                    })
                    ->addColumn('borrar', function ($producto) {
                        return '<a href="javascript:void(0)" title="Elimina producto"><i class="fa fa-trash-o text-danger borrar" aria-hidden="true" id="' . $producto['id'] . '"></i></a>';
                    })
                    ->rawColumns(['id', 'codigobarra', 'marca', 'rubro', 'borrar'])
                    ->make(true);
            } else {
                return Datatables::of($producto)
                    ->addIndexColumn()
                    ->make(true);
            }
        }

        return view('admin.productos.index');
    }

    public function estadisticas(Request $request)
    {
        $productos = DB::table('producto as t1')
            ->join('marca as t2', 't1.marca', '=', 't2.id')
            ->join('detalle_venta as t3', 't1.id', '=', 't3.producto')
            ->join('venta as t4', 't3.venta', '=', 't4.id')
            ->select('t1.*', 't2.nombre as marca')
            ->groupBy('t1.id')
            ->orderBy('t1.nombre', 'ASC')
            ->where('tipocomprobante', '=', 2)->get();


        $marca      = Marca::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        return view('admin.productos.estadisticas', compact('productos', 'marca'));
    }

    public function detalleestadistica(Request $request)
    {
        $producto   = $request->producto;

        $ventas     = Venta::whereHas(
            'detalleventas',
            function ($q) use ($producto) {
                $q->Where('producto', $producto);
            }
        )->orderBy('fecha', 'DESC')->get();

        $producto   = Producto::find($producto);

        $detalle    = DetalleVenta::where('producto', '=', $request->producto)->get();

        $cantidad   = $detalle->count();
        $promedio   = $detalle->sum('precio') / $cantidad;

        return view('admin.productos.detalleEstadistica', compact('ventas', 'producto', 'cantidad', 'promedio'));
    }


    public function create()
    {
        $rubro      = Rubro::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $marca      = Marca::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $proveedor  = Proveedor::orderBy('nombreempresa', 'ASC')->get();

        return view('admin.productos.create', compact('rubro', 'proveedor', 'marca'));
    }


    public function store(ProductoRequest $request)
    {
        $name = null;

        if ($request->file()) {
            $path   = public_path() . '/images/upload/productos/';
            $file   = $request->file('image');
            $name   = $file->getClientOriginalName();

            $width  = 600;
            $height = 600;

            $img    = Image::make($file->getRealPath());
            $img->height() > $img->width() ? $width = null : $height = null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . '/' . $name);
        }

        $producto = new Producto($request->all());
        $producto->precioventa = $request->preciolista * $request->bonificacion * $request->flete * $request->margen;
        isset($request->actdolar) ? $producto->actdolar = 1 : $producto->actdolar = 0;
        $producto->image = $name;
        $producto->save();

        return redirect()->route('producto.edit', $producto->id);
    }


    public function edit($id)
    {
        $producto   = Producto::find($id);
        $rubro      = Rubro::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $marca      = Marca::orderBy('nombre', 'ASC')->pluck('nombre', 'id');
        $proveedor  = Proveedor::orderBy('nombreempresa', 'ASC')->get();

        return view('admin.productos.edit', compact('producto', 'rubro', 'proveedor', 'marca'));
    }


    public function update(ProductoRequest $request, $id)
    {
        $producto   = Producto::find($id);
        $name       = $producto->image;

        if ($request->file()) {
            $path   = public_path() . '/images/upload/productos/';

            if (\File::exists($path . $producto->image)) {
                \File::delete($path . $producto->image);
            }

            $file   = $request->file('image');
            $name   = $file->getClientOriginalName();

            $width  = 600;
            $height = 600;

            $img    = Image::make($file->getRealPath());
            $img->height() > $img->width() ? $width = null : $height = null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . '/' . $name);
        } else {
            $name = $producto->image;
        }

        $producto->fill($request->all());
        $producto->precioventa  = $request->preciolista * $request->bonificacion * $request->flete * $request->margen;

        isset($request->activo) ? $producto->activo = 1 : $producto->activo = 0;

        isset($request->actdolar) ? $producto->actdolar = 1 : $producto->actdolar = 0;

        $producto->image = $name;
        $producto->save();

        $notification = array(
            'message' => $producto->nombre . ' se ha guardado correctamente !',
            'alert-type' => 'success'
        );

        return redirect()->route('producto.index')->with($notification);
    }

    public function asociarProv(Request $request)
    {
        $idprod     = $request->idprod;
        $idprov     = $request->idprov;
        $accion     = $request->accion;

        $producto   = Producto::findOrFail($idprod);
        $proveedor  = Proveedor::findOrFail($idprov);

        if ($accion == 1) {   // agregar
            $producto->proveedores()->attach($idprov);
        } else {              // quitar
            $producto->proveedores()->detach($idprov);
        }

        return response()->json($proveedor->nombreempresa);
    }


    public function destroy(Request $request)
    {
        $producto   = Producto::find($request->id);

        $path       = public_path() . '/images/upload/productos/';

        if (\File::exists($path . $producto->image)) {
            \File::delete($path . $producto->image);
        }

        $producto->delete();

        return response()->json();
    }

    public function excel()
    {
        /**
         * toma en cuenta que para ver los mismos
         * datos debemos hacer la misma consulta
         **/

        Excel::create('productos', function ($excel) {
            $excel->sheet('Excel Productos', function ($sheet) {
                //$producto = Producto::select('nombre', 'descripcion', 'precioventa', 'stockactual')->get();
                //$producto = Producto::all();
                $producto = Producto::join('marca', 'producto.marca', 'marca.id')
                    ->select(
                        'producto.nombre as Producto',
                        'producto.precioventa as Precio Vta',
                        'producto.stockactual as Stock Actual',
                        'marca.nombre as Marca'
                    )->get();
                $sheet->fromArray($producto);
                $sheet->setOrientation('landscape');
            });
        })->export('xls');
    }
}