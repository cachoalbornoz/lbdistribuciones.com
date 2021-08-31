@extends('base.base')

@section('title', 'Detalle pedido')

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('/css/jquery.fancybox.min.css') }}">
@endsection

@section('breadcrumb')
    {!! Breadcrumbs::render('pedido.detalle', $pedido) !!}
@stop

@section('content')

    <div class="card">
        <div class="card-body border border-primary">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="table-responsive">
                        <table class="table small table-borderless" style="font-size: 1em">
                            <tr>
                                <td style="width: 15%">Razón social</td>
                                <td>
                                    <b> {{ $pedido->Contacto->nombreempresa . ' ' . $pedido->Contacto->nombreCompleto() }}
                                    </b>
                                </td>
                                <td style="width: 15%">
                                    Fecha
                                </td>
                                <td>
                                    <b> {{ date('d-m-Y', strtotime($pedido->fecha)) }} </b>
                                </td>
                                <td style="width: 150px" class=" text-center">
                                    <a href="{{ route('pedido.descartar', $pedido->id) }}"
                                        class="btn btn-light btn-block border">
                                        <i class="fa fa-trash text-danger" aria-hidden="true"></i> Anula
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Vendedor</td>
                                <td><b>{{ $pedido->Vendedor->nombrecompleto() }}</b></td>
                                <td>Observaciones</td>
                                <td><b> {{ $pedido->observaciones }} </b></td>
                                <td style="width: 150px" class=" text-center">
                                    <a href="{{ route('pedido.index') }}" class="btn btn-light btn-block border">
                                        <i class="fa fa-floppy-o text-info" aria-hidden="true"></i> Finaliza
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="detalle">
                        @include('admin.detallepedidos.detallepedido')
                    </div>
                </div>
            </div>

            <div class="row ml-1 mb-3">
                <div class="col-xs-12 col-sm-4 col-lg-4">
                    {!! Form::model(Request::all(), ['route' => ['detallepedido.index', $pedido->id], 'method' => 'get']) !!}
                    {!! Form::text('palabra', null, ['id' => 'palabra', 'class' => 'form-control', 'autofocus', 'placeholder' => 'Escriba producto a buscar', 'onkeyup' => 'return buscar()']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row ml-1 mb-3">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="table-responsive">
                        <div class="producto">
                            @include('admin.detallepedidos.detalleproducto')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')

    <script src="{{ asset('/js/jquery.fancybox.min.js') }}"> </script>

    <script>
        function buscar() {

            var route = '{{ route('detallepedido.index', $pedido->id) }}';
            var token = $('input[name=_token]').val();
            $.ajax({

                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'GET',
                dataType: 'json',
                data: {
                    palabra: $('#palabra').val()
                },
                success: function(data) {
                    $('.producto').html(data);
                }
            });
        }

        function eliminarReg(id) {

            var route = '{{ route('detallepedido.destroy') }}';
            var token = $('input[name=_token]').val();
            var pedido = {{ $pedido->id }};

            $.ajax({

                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    pedido: pedido,
                    id: id
                },
                success: function(data) {
                    $('.detalle').html(data);
                    $('#palabra').select();
                }
            });

        }

        function guardar(id) {
            var route = '{{ route('detallepedido.insert') }}';
            var token = $('input[name=_token]').val();
            var pedido = {{ $pedido->id }};
            var tipocomprob = 1;

            var producto = id;
            var cantidad = document.getElementById("cantidad" + id).value;
            var precio = document.getElementById("precio" + id).value;
            var descuento = 0;

            if (cantidad == 0) {

                var texto = 'Complete la cantidad a pedir ';
                toastr.info(texto, 'Pedidos', {
                    closeButton: false
                });
                $("#cantidad" + id).select();
            } else {

                $.ajax({

                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        pedido: pedido,
                        tipocomprobante: tipocomprob,
                        producto: producto,
                        cantidad: cantidad,
                        precio: precio,
                        descuento: descuento
                    },
                    success: function(data) {
                        $('.detalle').html(data);
                        $('#palabra').select();
                    }
                });
            }
        }

        $(document).on('keydown', function(e) {

            if (e.keyCode === 115) { //F4 -
                var route = '{{ route('pedido.index') }}';
                window.location.href = route;
            }

        });
    </script>
@stop
