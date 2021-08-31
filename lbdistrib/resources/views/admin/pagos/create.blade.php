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
                        Pago a proveedores
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">

            {!! Form::open(['route' => 'pago.store', 'method' => 'POST']) !!}
            {!! Form::hidden('total', 0, ['class' => 'form-control', 'step' => 'any']) !!}

            <div class="row mb-5">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    {!! Form::label('proveedor', 'Razón social') !!}
                    @if ($id == 0)
                        {!! Form::select('proveedor', $proveedor, null, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione proveedor']) !!}
                    @else
                        {!! Form::select('proveedor', $proveedor, $proveedor, ['class' => 'form-control']) !!}
                    @endif
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2">
                    {!! Form::label('comprobante', 'Tipo comprobante') !!}
                    {!! Form::select('tipocomprobante', $tipocomprobante, $tipocomprobante, ['class' => 'form-control font-weight-bolder']) !!}
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                    {!! Form::label('nro', 'Nro') !!}
                    {!! Form::number('nro', $nroPago, ['class' => 'form-control text-center', 'placeholder' => 'Nro comprobante']) !!}
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                    {!! Form::label('fecha', 'Fecha') !!}
                    {!! Form::date('fecha', \Carbon\Carbon::now(), ['class' => 'form-control text-center', 'placeholder' => 'Fecha comprobante']) !!}
                </div>

            </div>
            <div class="row mb-3">
                <div class="col-xs-12 col-md-10 col-lg-10">

                </div>
                <div class="col-xs-12 col-md-2 col-lg-2 text-center">
                    {!! Form::submit('Cargar ', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@stop
