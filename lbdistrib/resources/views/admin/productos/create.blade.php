@extends('base.base')

@section('title', 'Crear producto')

@section('breadcrumb')
{!! Breadcrumbs::render('producto.create') !!}
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
                    Crear producto
                </h5>
            </div>
        </div>
    </div>

    <div class="card-body">

        {!! Form::open(['route' => 'producto.store', 'method'=> 'POST', 'files' => 'true']) !!}

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

                                </div>
                                <div class="col-xs-12 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('image', 'Imagen del producto') !!}
                                        {!! Form::file('image', null, ['class' => 'file']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-6 col-lg-6">

                                    <div class="form-group">
                                        {!! Form::label('codigobarra', 'Codigo') !!}
                                        {!! Form::number('codigobarra', 0, ['class' => 'form-control', 'autofocus' => 'true', 'placeholder' => 'Código del producto', 'step'=>'any']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('nombre', 'Nombre producto') !!}
                                        {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre del producto']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('descripcion', 'Detalle del producto') !!}
                                        {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Describa el producto completo']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('rubro', 'Rubro') !!}
                                        {!! Form::select('rubro', $rubro, null, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione rubro']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('marca', 'Marca') !!}
                                        {!! Form::select('marca', $marca, null, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione marca']) !!}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('preciolista', '$ - Lista') !!}
                                        {!! Form::number('preciolista', 0, ['class' => 'form-control', 'placeholder' => 'precio lista', 'step'=>'any']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('precioventa', '$ - Venta') !!}
                                        {!! Form::number('precioventa', null, ['class' => 'form-control', 'disabled' ,'placeholder' => 'Precio venta se calcula solo con los índices']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('stockaviso', 'Stock de aviso') !!}
                                        {!! Form::number('stockaviso', 0, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('stockactual', 'Stock actual') !!}
                                        {!! Form::number('stockactual', 0, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab-2">
                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        {!! Form::label('bonificacion', 'Bonificacion') !!}
                                        {!! Form::text('bonificacion', 1, ['class' => 'form-control', 'step'=>'any']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('flete', 'Flete') !!}
                                        {!! Form::text('flete', 1, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('margen', 'Margen') !!}
                                        {!! Form::text('margen', 1, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="actdolar" id="actdolar"> U$s - actualizable a valor dolar
                                        </label>
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
                {!! Form::submit('Cargar ', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>

@endsection