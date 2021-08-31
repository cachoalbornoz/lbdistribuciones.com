@extends('base.base')

@section('title', 'Carga pedido')

@section('breadcrumb')
    {!! Breadcrumbs::render('pedido.facturacion', $pedido) !!}
@stop

@section('content')

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    Facturación pedido
                </div>
            </div>
        </div>

        {!! Form::open(['route' => ['venta.registrarVta'], 'method' => 'post', 'class' => 'horizontal']) !!}

        <div class="card-body">
            {!! Form::text('id_pedido', $pedido->id, ['class' => 'd-none']) !!}

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <table class="table table-borderless" style="font-size: 1em">
                        <tr>
                            <td style="width: 15%">Razón social</td>
                            <td style="width: 60%">
                                {{ $pedido->Contacto->nombreempresa . ' ' . $pedido->Contacto->nombreCompleto() }}
                                {!! Form::hidden('razon', $pedido->Contacto->nombreempresa . ' ' . $pedido->Contacto->nombreCompleto(), ['id' => 'razon']) !!}
                            </td>
                            <td style="width: 15%">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa fa-calendar text-primary"></i> &nbsp; Fecha
                                </span>
                            </td>
                            <td style="width: 15%">
                                {!! Form::date('fecha', $pedido->fecha, ['class' => 'form-control text-center text-bold']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Vendedor</td>
                            <td>
                                {{ $pedido->Vendedor->nombrecompleto() }}
                                {!! Form::hidden('nombre', $pedido->Vendedor->nombrecompleto(), ['id' => 'nombre']) !!}
                            </td>
                            <td>
                                <span class="input-group-text">
                                    Factura Nro
                                </span>
                            </td>
                            <td>
                                {!! Form::number('nro', $nroComprobante, ['id' => 'nro', 'class' => 'form-control text-center text-bold']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Observaciones</td>
                            <td>
                                {!! Form::text('observaciones', $pedido->observaciones, ['id' => 'observaciones', 'class' => 'form-control text-bold']) !!}
                            </td>
                            <td>
                                <span class="input-group-text">
                                    Descuento
                                </span>
                            </td>
                            <td>
                                <div class="input-group">
                                    {!! Form::number('descuento', 0, ['id' => 'descuento', 'class' => 'form-control text-bold text-center', 'step' => 'any']) !!}
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    @include('admin.detallepedidos.detallefacturacion')
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div id="totalfacturacion">
                        @include('admin.detallepedidos.detalletotal')
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <a href="{{ route('pedido.index') }}" class="btn btn-light border btn-link"> Volver </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 text-right">
                    {!! Form::submit('Registrar venta', ['class' => 'btn btn-success']) !!}
                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>


@endsection

@section('js')

    <script>
        $(document).on('keydown', function(e) {

            if (e.keyCode === 13) { // F10

                console.log('Enter');
                return false;
            }

        });

        var route = '{{ route('detallepedido.update') }}';
        var token = $('input[name=_token]').val();

        function actualizar(id, producto) {

            var id = id;
            var cantidad = $("#cantidad" + producto).val();
            var cantentrega = $("#cantidadentregada" + producto).val();
            var descuento = $('#descuento').val();

            descuento > 0 ? descuento = descuento / 100 : descuento = 0;

            $.ajax({

                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    cant: cantentrega,
                    descuento: descuento
                },
                success: function(data) {
                    $('#totalfacturacion').html(data);
                }
            });

        }
    </script>

@stop
