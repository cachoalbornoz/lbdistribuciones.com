@extends('base.base')

@section('title', 'Vincular marcas')

@section('breadcrumb')
    {!! Breadcrumbs::render('inicio') !!}
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        Vincular marcas al vendedor
                    </h5>
                </div>
            </div>
        </div>
    </div>


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

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        Lista de Marcas a asociar - vendedor :: <b>{{ $vendedor->name }}</b>
                    </h5>
                </div>

                <div class="card-body">

                    {!! Form::model($vendedor, ['route' => ['vendedor.update'], 'method' => 'POST']) !!}


                    <div class="form-group">
                        {!! Form::hidden('id', $vendedor->id) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                    </div>


                    <div class="form-group">
                        <ul class="list-unstyled">
                            @foreach ($marcas as $marca)
                                <li>
                                    <label class="checkbox-inline">
                                        {{ Form::checkbox('marcas[]', $marca->id, null) }}
                                        {{ $marca->nombre }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection
