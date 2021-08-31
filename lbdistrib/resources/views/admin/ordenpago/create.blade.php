@extends('base.base')

@section('title', 'Carga pagos')

@section('breadcrumb')
    {!! Breadcrumbs::render('pago.create') !!}
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
                        Orden de pagos
                    </h5>
                </div>
            </div>
        </div>

        {!! Form::open(['route' => 'ordenpago.store', 'method' => 'POST']) !!}

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    {!! Form::label('proveedor', 'Razón social') !!}
                    @if ($id == 0)
                        {!! Form::select('proveedor', $proveedor, null, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione proveedor']) !!}
                    @else
                        {!! Form::select('proveedor', $proveedor, $proveedor, ['class' => 'form-control']) !!}
                    @endif
                </div>

            </div>
            <div class="col-xs-12 col-sm-3 col-lg-3">
                {!! Form::hidden('total', 0, ['class' => 'form-control', 'step' => 'any']) !!}
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-4 col-lg-6">
                    <span class="input-group-text">
                        Comprobante &nbsp;
                        {!! Form::select('tipocomprobante', $tipocomprobante, $tipocomprobante, ['class' => 'form-control']) !!}
                    </span>
                </div>
                <div class="col-xs-12 col-sm-3 col-lg-3">
                    <span class="input-group-text">
                        Fecha &nbsp;
                        {!! Form::date('fecha', \Carbon\Carbon::now(), ['class' => 'form-control text-center', 'placeholder' => 'Fecha comprobante']) !!}
                    </span>
                </div>
                <div class="col-xs-12 col-sm-3 col-lg-3">
                    <span class="input-group-text">
                        Nro &nbsp;
                        {!! Form::number('nro', $nroPago, ['class' => 'form-control text-center', 'placeholder' => 'Nro comprobante']) !!}
                    </span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-xs-12 col-md-1 col-lg-1">
                    {!! Form::submit('Cargar ', ['class' => 'btn btn-info']) !!}
                </div>
            </div>
        </div>

        {!! Form::close() !!}

    </div>

@stop
