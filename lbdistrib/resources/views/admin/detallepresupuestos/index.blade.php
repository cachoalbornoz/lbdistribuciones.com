@extends('base.base')

@section('title', 'Detalle presupuesto')

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('/css/jquery.fancybox.min.css') }}">
@endsection

@section('breadcrumb')
    {!! Breadcrumbs::render('presupuesto.detalle', $presupuesto) !!}
@stop

@section('content')

    <div class="card">
        <div class="card-body border border-primary">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="table-responsive">
                        <table class="table small table-borderless" style="font-size: smaller">
                            <tr>
                                <td>
                                    Razón social
                                </td>
                                <td>
                                    <b> {{ $presupuesto->Contacto->nombreempresa . ' ' . $presupuesto->Contacto->nombreCompleto() }}
                                    </b>
                                </td>
                                <td style="width: 15%">
                                    Fecha
                                </td>
                                <td style=" width: 15%">
                                    <b> {{ date('d-m-Y', strtotime($presupuesto->fecha)) }} </b>
                                </td>
                                <td style=" width: 15%" class=" text-center">
                                    <a href="{{ route('pedido.descartar', $presupuesto->id) }}"
                                        class="btn btn-light btn-block border">
                                        <i class="fa fa-trash text-danger" aria-hidden="true"></i> Anula
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Vendedor</td>
                                <td><b>{{ $presupuesto->Vendedor->nombrecompleto() }}</b></td>
                                <td></td>
                                <td></td>
                                <td class=" text-center">
                                    <a href="{{ route('presupuesto.index') }}" class="btn btn-light btn-block border">
                                        <i class="fa fa-floppy-o text-info" aria-hidden="true"></i> Finaliza
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td><b> {{ $presupuesto->observaciones }} </b></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> Desc. </span>
                                        </div>
                                        {!! Form::number('descuento', 0, ['id' => 'descuento', 'class' => 'form-control text-center', 'step' => 'any', 'autofocus' => 'true']) !!}
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
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
                        @include('admin.detallepresupuestos.detallepresupuesto')
                    </div>
                </div>
            </div>

            <div class="row ml-1 mb-3">
                <div class="col-xs-12 col-sm-4 col-lg-4">
                    {!! Form::model(Request::all(), ['route' => ['detallepresupuesto.index', $presupuesto->id], 'method' => 'get']) !!}
                    {!! Form::text('palabra', null, ['id' => 'palabra', 'class' => 'form-control', 'autofocus', 'placeholder' => 'Escriba producto a buscar', 'onkeyup' => 'return buscar()']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="producto">
                @include('admin.detallepresupuestos.detalleproducto')
            </div>

        </div>
    </div>

@endsection

@section('js')

    <script src="{{ asset('/js/jquery.fancybox.min.js') }}"> </script>

    <script>
        function buscar() {

            var route = '{{ route('detallepresupuesto.index', $presupuesto->id) }}';
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

            var route = '{{ route('detallepresupuesto.destroy') }}';
            var token = $('input[name=_token]').val();
            var presupuesto = {{ $presupuesto->id }};

            $.ajax({

                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    presupuesto: presupuesto,
                    id: id
                },
                success: function(data) {
                    $('.detalle').html(data);
                    $('#palabra').select();
                }
            });

        }

        function guardar(id) {
            var route = '{{ route('detallepresupuesto.insert') }}';
            var token = $('input[name=_token]').val();
            var presupuesto = {{ $presupuesto->id }};
            var tipocomprob = 1;

            var producto = id;
            var cantidad = document.getElementById("cantidad" + id).value;
            var precio = document.getElementById("precio" + id).value;
            var descuento = $('#descuento').val();

            descuento = (descuento > 0) ? descuento / 100 : 0;

            if (cantidad == 0) {

                var texto = 'Complete la cantidad a pedir ';
                toastr.info(texto, 'Presupuestos', {
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
                        presupuesto: presupuesto,
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
                var route = '{{ route('presupuesto.index') }}';
                window.location.href = route;
            }
        });
    </script>
@stop
