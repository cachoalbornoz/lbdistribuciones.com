@extends('base.base')

@section('title', 'Carga pedidos')

@section('breadcrumb')
    {!! Breadcrumbs::render('pedido') !!}
@stop

@section('content')

    <div class="row mb-2">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Nota Pedido</h5>
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

    {!! Form::model($pedido, ['route' => ['pedido.update', $pedido->id], 'method' => 'POST']) !!}

    {!! Form::hidden('pedido', $pedido->id) !!}

    {!! Form::select('tipocomprobante', $tipocomprobante, $tipocomprobante, ['class' => 'd-none']) !!}

    <div class="card border border-primary">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <table class="table table-borderless" style="font-size: 1em">
                    <tr>
                        <td style="width: 15%">Razón social</td>
                        <td>
                            {!! Form::select('contacto', $contacto, null, ['id' => 'contacto', 'class' => 'select2', 'placeholder' => 'Seleccione cliente']) !!}
                        </td>
                        <td style="width: 15%">
                            <span class="input-group-text">
                                <i class="fa fa-calendar text-primary"></i> &nbsp; Fecha
                            </span>
                        </td>
                        <td style="width: 15%">
                            {!! Form::date('fecha', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Fecha comprobante']) !!}
                        </td>
                    </tr>
                    <tr>
                        <td>Vendedor</td>
                        <td>
                            {!! Form::select('vendedor', $vendedor, null, ['id' => 'vendedor', 'class' => 'form-control']) !!}
                        </td>
                        <td>
                            <span class="input-group-text">
                                Forma de pago
                            </span>
                        </td>
                        <td>
                            {!! Form::select('formapago', $formapago, null, ['class' => 'form-control']) !!}
                        </td>
                    </tr>
                    <tr>
                        <td>Observaciones</td>
                        <td>
                            {!! Form::text('observaciones', null, ['class' => 'form-control', 'placeholder' => 'max 150 caracteres']) !!}
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mr-0">
            <div class="col-xs-12 col-md-12 col-lg-12 text-right">
                {!! Form::submit('Actualizar ', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12 text-right">
                &nbsp;
            </div>
        </div>

    </div>

    {!! Form::close() !!}

@stop

@section('js')

    <script>
        $(document).ready(function() {


        })

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
