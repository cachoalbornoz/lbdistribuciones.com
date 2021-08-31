@extends('base.base')

@section('title', 'Carga cobros')

@section('breadcrumb')
    {!! Breadcrumbs::render('cobro') !!}
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
                        Cobro
                    </h5>
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(['route' => 'cobro.store', 'method' => 'POST']) !!}

    <div class="card">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-8 col-lg-8 font-weight-bolder">
                    {!! Form::label('contacto', 'Razón social') !!}
                    @if ($id == 0)
                        {!! Form::select('contacto', $contacto, null, ['class' => 'form-control select2', 'placeholder' => 'Seleccione un cliente']) !!}
                    @else
                        {!! Form::select('contacto', $contacto, $contacto, ['class' => 'form-control']) !!}
                    @endif
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                    <b>{!! Form::label('nro', 'Nro comprobante') !!}</b>
                    {!! Form::number('nro', $nroCobro, ['class' => 'form-control text-center', 'placeholder' => 'Nro comprobante']) !!}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-4 col-lg-4">
                    {!! Form::label('tipocomprobante', 'Tipo Comprobante') !!}
                    {!! Form::select('tipocomprobante', $tipoComprobante, 16, ['class' => 'form-control', 'placeholder' => 'Seleccione un comprobante']) !!}
                </div>
                <div class="col-xs-12 col-sm-4 col-lg-4">

                    {!! Form::label('fecha', 'Fecha') !!}
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class=" input-group-text">
                                <i class="fa fa-calendar text-primary"></i>
                            </span>
                        </div>
                        {!! Form::date('fecha', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Fecha comprobante']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-lg-4">
                    {!! Form::hidden('total', 0, ['class' => 'form-control', 'placeholder' => 'importe', 'step' => 'any', 'autofocus' => 'true']) !!}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-8 col-lg-8">
                    {!! Form::label('observaciones', 'Observaciones') !!}
                    {!! Form::text('observaciones', null, ['class' => 'form-control', 'placeholder' => 'Observaciones de cobro']) !!}
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 text-right">
                    {!! Form::submit('Cargar ', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>

    </div>

    {!! Form::close() !!}

@stop
