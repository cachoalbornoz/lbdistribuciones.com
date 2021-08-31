@extends('base.base')

@section('title', 'Carga compras')

@section('breadcrumb')
    {!! Breadcrumbs::render('compra.create') !!}
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
                        Compras
                    </h5>
                </div>
            </div>
        </div>


        <div class="card-body">

            {!! Form::open(['route' => 'compra.store', 'method' => 'POST']) !!}

            <div class="card border border-primary">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-12">

                        <table class="table table-borderless" style="font-size: 1em">
                            <tr>
                                <td style="width: 15%">
                                    Razón social
                                </td>
                                <td>
                                    @if ($id == 0)
                                        {!! Form::select('proveedor', $proveedor, null, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione proveedor']) !!}
                                    @else
                                        {!! Form::select('proveedor', $proveedor, $proveedor, ['class' => 'form-control']) !!}
                                    @endif
                                </td>
                                <td style="width: 15%">
                                    Fecha
                                </td>
                                <td>
                                    {!! Form::date('fecha', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Fecha comprobante']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Comprobante</td>
                                <td>
                                    {!! Form::select('tipocomprobante', $tipocomprobante, null, ['class' => 'form-control']) !!}
                                </td>
                                <td></td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td>Nro comprobante</td>
                                <td>
                                    {!! Form::number('nro', $nroComprobante, ['class' => 'form-control', 'placeholder' => 'Nro comprobante']) !!}
                                </td>
                                <td>Forma pago</td>
                                <td>
                                    {!! Form::select('formapago', $tipoformapago, null, ['class' => 'form-control']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td>
                                    {!! Form::text('observaciones', null, ['class' => 'form-control', 'placeholder' => 'Observaciones de la compra. Ej flete, etc ...']) !!}
                                </td>
                                <td></td>
                                <td>
                                    {!! Form::submit('Cargar ', ['class' => 'btn btn-primary']) !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@stop


@section('js')

    <script>



    </script>

@endsection
