@extends('base.base')

@section('title', 'Editar proveedor')

@section('breadcrumb')
    {!! Breadcrumbs::render('proveedor.edit', $proveedor) !!}
@stop

@section('content')

    @if (isset($proveedor))
        @include('base.header-proveedor')
    @endif

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

    {!! Form::model($proveedor, ['route' => ['proveedor.update', $proveedor->id], 'method' => 'PUT']) !!}

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>
                        Datos del proveedor
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-lg-4">
                    <div class="form-group">
                        {!! Form::label('nombreempresa', 'Razón social') !!}
                        {!! Form::text('nombreempresa', $proveedor->nombreempresa, ['class' => 'form-control', 'placeholder' => 'Razon social']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('apellido', 'Apellido') !!}
                        {!! Form::text('apellido', $proveedor->apellido, ['class' => 'form-control', 'placeholder' => 'Apellido']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('nombres', 'Nombres') !!}
                        {!! Form::text('nombres', $proveedor->nombres, ['class' => 'form-control', 'placeholder' => 'Nombres']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('domicilio', 'Domicilio Nro - (Dpto / Manzana / Barrio / Sector)') !!}
                        {!! Form::text('domicilio', $proveedor->domicilio, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', $proveedor->email, ['class' => 'form-control', 'placeholder' => 'Correo electronico']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 col-lg-4">
                    <div class="form-group">
                        {!! Form::label('telefono', 'Telefono') !!}
                        {!! Form::text('telefono', $proveedor->telefono, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('celular', 'Celular / Movil') !!}
                        {!! Form::text('celular', $proveedor->celular, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('ciudad', 'Ciudad') !!}
                        {!! Form::select('ciudad', $ciudad, $proveedor->ciudad, ['class' => 'form-control', 'placeholder' => 'Seleccione ciudad']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('cuit', 'Nro Cuit') !!}
                        {!! Form::text('cuit', $proveedor->cuit, ['class' => 'form-control', 'maxlength' => '11']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('tiporesponsable', 'Tipo responsable') !!}
                        {!! Form::select('tiporesponsable', $tiporesponsable, $proveedor->tiporesponsable, ['class' => 'form-control', 'placeholder' => 'Seleccione responsabilidad']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 col-lg-4">
                    <div class="form-group">
                        <div class="form-group">
                            {!! Form::label('saldo', 'Saldo') !!}
                            {!! Form::text('saldo', $proveedor->saldo, ['class' => 'form-control text-center']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('remamente', 'Saldo Acreditar') !!}
                        {!! Form::number('remanente', null, ['class' => 'form-control text-center', 'step' => 'any']) !!}
                    </div>

                    <div class="form-group">

                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    {!! Form::submit('Guardar ', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection
