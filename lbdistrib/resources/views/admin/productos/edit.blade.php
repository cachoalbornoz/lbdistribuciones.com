@extends('base.base')

@section('title', 'Editar producto')

@section('breadcrumb')
{!! Breadcrumbs::render('producto.edit', $producto) !!}
@stop

@section('content')

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <h5>
                    Editar producto
                </h5>
            </div>
        </div>
    </div>

    <div class="card-body">
        {!! Form::model($producto,['route' => ['producto.update', $producto->id], 'method' => 'PUT', 'files' => 'true']) !!}

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-1" data-toggle="tab">Detalle </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-2" data-toggle="tab">Indices </a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane show active" id="tab-1">

                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-6 col-lg-6">
                                    {!! Form::label('image', 'Image') !!}
                                    {!! Form::file('image', null, ['class' => 'file']) !!}
                                </div>

                                <div class="col-xs-12 col-sm-6 col-lg-6 text-center">
                                    @if(isset($producto->image))
                                    <img src="{{ asset('images/upload/productos/'. $producto->image) }}" class="img-thumbnail" width="150" height="150">
                                    @else
                                    <img src="{{ asset('images/frontend/imagen-no-disponible.png') }}" class="img-rounded" height="75px" width="75px">
                                    @endif
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('codigobarra', 'Codigo') !!}
                                        {!! Form::text('codigobarra', $producto->codigobarra, ['class' => 'form-control', 'placeholder' => 'Código del producto', 'step'=>'any']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('nombre', 'Nombre producto') !!}
                                        {!! Form::text('nombre', $producto->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre del producto']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('descripcion', 'Detalle del producto') !!}
                                        {!! Form::text('descripcion', $producto->descripcion, ['class' => 'form-control', 'placeholder' => 'Describa el producto completo']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('rubro', 'Rubro') !!}
                                        {!! Form::select('rubro', $rubro, $producto->rubro, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione rubro']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('marca', 'Marca') !!}
                                        {!! Form::select('marca', $marca, $producto->marca, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione marca']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('preciolista', '$ - Lista') !!}
                                        {!! Form::number('preciolista', $producto->preciolista, ['class' => 'form-control', 'placeholder' => 'precio lista', 'step'=>'any']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('precioventa', '$ - Venta') !!}
                                        {!! Form::number('precioventa', $producto->precioventa, ['class' => 'form-control', 'placeholder' => 'precio venta', 'step'=>'any']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('stockaviso', 'Stock de aviso') !!}
                                        {!! Form::number('stockaviso', $producto->stockaviso, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('stockactual', 'Stock actual') !!}
                                        {!! Form::number('stockactual', $producto->stockactual, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        <br>

                                        <div class="col-xs-12 col-sm-6 col-lg-6">
                                            @if ($producto->activo == 1) <span class="badge bg-green">ACTIVO</span> @else <span class="badge bg-red">INACTIVO</span> @endif
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-lg-6">
                                            <label class=" pull-right">
                                                <input id="activo" name="activo" type="checkbox" @if ($producto->activo == 1) checked @endif value="{{ $producto->activo }}">
                                                @if ($producto->activo == 1) Activo @else Activar @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab-2">
                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('bonificacion', 'Bonificacion') !!}
                                        {!! Form::text('bonificacion', $producto->bonificacion, ['class' => 'form-control', 'step'=>'any']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('flete', 'Flete') !!}
                                        {!! Form::text('flete', $producto->flete, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('margen', 'Margen') !!}
                                        {!! Form::text('margen', $producto->margen, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label class="checkbox-inline">
                                            <input id="actdolar" name="actdolar" type="checkbox" @if ($producto->actdolar == 1) checked @endif value="{{$producto->actdolar}}">
                                            U$s - actualizable a valor dolar
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab-4">
                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-6 col-lg-6">
                                    <div class="box-body" style="overflow-y: scroll; height: 200px">
                                        <table class="table table-bordered table-hover table-responsive" id="maestroProv">
                                            <tbody>
                                                @foreach($proveedor as $prov)
                                                <tr id="maestroProv{{$prov->id}}">
                                                    <td>{{ $prov->nombreempresa }}</td>
                                                    <td class="text-center"><input type="checkbox" value="{{ $prov->id }}" onclick="asociarProv(this.value, 1)"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-6">
                                    <div class="box-body" style="overflow-y: scroll; height: 200px">
                                        <table class="table table-bordered table-hover table-responsive" id="maestroProvlink">
                                            <tbody>
                                                @foreach($producto->proveedores as $p)
                                                <tr id="maestroProvlink{{$p->id}}">
                                                    <td>{{ $p->nombreempresa }}</td>
                                                    <td class="text-center"><input type="checkbox" value="{{ $p->id }}" onclick="asociarProv(this.value, 0)"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                {!! Form::submit('Actualizar ', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>
</div>

@endsection

@section('js')

<script>
    function asociarProv(id, accion){

			var token 	= $('input[name=_token]').val();

			var id 		= id;
			var route 	= '{{ route('producto.asociarProv') }}';

			$.ajax({

				url 	: route,
				headers : {'X-CSRF-TOKEN': token},
				type 	: 'POST',
				dataType: 'json',
				data 	: {
					idprod: {{ $producto->id }},
					idprov: id,
					accion: accion
				},
				success: function (data) {

					console.log(data);

					if(accion == 1){ 	// Agrega proveedor

						var fila = '<tr id="maestroProvlink'+ id +'"><td>'+data+'</td><td class="text-center"><input type="checkbox" value="' + id + '" onclick="asociarProv('+ id +', 0)"></td></tr>';
						$('#maestroProvlink').append(fila);
						$('#maestroProv' + id).remove();

					}else{				// Quita proveedor

						var fila = '<tr id="maestroProv'+ id +'"><td>'+data+'</td><td class="text-center"><input type="checkbox" value="' + id + '" onclick="asociarProv('+ id +', 1)"></td></tr>';
						$('#maestroProv').append(fila);
						$('#maestroProvlink' + id).remove();

					}

					sortTable("maestroProv");
					sortTable("maestroProvlink");

			    },
			});
		}

</script>
@stop