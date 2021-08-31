<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Response;

use App\Models\Rubro,
    App\Models\SubRubro;



use Carbon\Carbon;

class RubroController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:rubro.index')->only('index');
        $this->middleware('permission:rubro.create')->only(['create', 'store']);
        $this->middleware('permission:rubro.edit')->only(['edit', 'update']);
        $this->middleware('permission:rubro.destroy')->only('destroy');
    }

    protected $rules =
    [
        'nombre' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    ];


    public function index(){

        $rubros     = Rubro::orderBy('nombre', 'ASC')->get();
        return view('admin.rubros.index', compact('rubros'));
    }

    public function data(){

        if($request->$request->ajax()){

            $rubros = Rubro::select('id', 'nombre');
            return Datatables::of($rubros)->make(true);
        }            
    }


    public function store(Request $request){

        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $rubro = new Rubro($request->all());
            $rubro->save();
            return response()->json($rubro);
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $rubro = Rubro::findOrFail($request->id);
            $rubro->nombre = $request->nombre;
            $rubro->save();
            return response()->json($rubro);
        }

    }

    public function destroy(Request $request)
    {
        $rubro = Rubro::findOrFail($request->id);
        $rubro->delete();

        return response()->json($rubro);
    }

}
