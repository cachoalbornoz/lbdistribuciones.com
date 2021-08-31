@extends('base.base')

@section('title',
    'Carga
    ventas',)

@section('breadcrumb')
    {!! Breadcrumbs::render('venta') !!}
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
                        Ventas
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">

            {!! Form::open(['route' => 'venta.store', 'method' => 'POST']) !!}

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
                                        {!! Form::select('contacto', $contacto, null, ['class' => 'form-control select2', 'placeholder' => 'Seleccione un cliente']) !!}
                                    @else
                                        {!! Form::select('contacto', $contacto, $contacto, ['class' => 'form-control']) !!}
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
                                <td>
                                    Comprobante
                                </td>
                                <td>
                                    {!! Form::select('tipocomprobante', $tipocomprobante, 2, ['class' => 'form-control']) !!}
                                </td>
                                <td>
                                    Vendedor
                                </td>
                                <td>
                                    {!! Form::select('vendedor', $vendedor, null, ['id' => 'vendedor', 'class' => 'form-control']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Nro comprobante
                                </td>
                                <td>
                                    {!! Form::number('nro', $nroComprobante, ['class' => 'form-control', 'placeholder' => 'Nro comprobante']) !!}
                                </td>
                                <td>
                                    Formapago
                                </td>
                                <td>
                                    {!! Form::select('formapago', $formapago, null, ['class' => 'form-control']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Observaciones
                                </td>
                                <td>
                                    {!! Form::text('observaciones', null, ['class' => 'form-control', 'placeholder' => 'Observaciones de la venta']) !!}
                                </td>
                                <td>
                                </td>
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
        $('#contacto').on('change', function() {

            var route = '{{ route('contacto.vendedor') }}';
            var token = $('input[name=_token]').val();
            var contacto = $('#contacto').val();

            $.ajax({

                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    contacto: contacto
                },
                success: function(data) {

                    var vendedor = data[0].vendedor;
                    $("#vendedor").val(vendedor);

                }
            });
        });
    </script>

@stop
