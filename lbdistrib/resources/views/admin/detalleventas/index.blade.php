@extends('base.base')

@section('title', 'Detalle Ventas')

@section('breadcrumb')
    {!! Breadcrumbs::render('venta.detalle', $venta) !!}
@stop

@section('content')

    <div class="card">
        <div
            class="card-body border                     @if ($venta->tipocomprobante == 8)
            border-danger
        @else border-primary @endif">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <table class="table small table-borderless">
                        <tr>
                            <td>
                                @if ($venta->tipocomprobante == 8)
                                    <span class="text-danger">
                                        {{ ucwords($venta->Tipocomprobante->comprobante) }}
                                    </span>
                                @else
                                    {{ ucwords($venta->Tipocomprobante->comprobante) }}
                                @endif
                            </td>
                            <td>
                                {{ $venta->Contacto->nombreempresa }} - {{ $venta->Contacto->nombreCompleto() }} -
                                Nro <b> {{ $venta->nro }} </b>
                            </td>
                            <td style=" width: 15%">Fecha</td>
                            <td style=" width: 15%"><b> {{ date('d-m-Y', strtotime($venta->fecha)) }} </b></td>
                            <td style=" width: 15%">
                                <button id="borrarVta" class="btn btn-light btn-block border">
                                    <i class="fa fa-trash text-danger" aria-hidden="true"></i> Anula
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Vendedor
                            </td>
                            <td>
                                <b>{{ $venta->Vendedor->nombrecompleto() }} </b>
                            </td>
                            <td>
                                Forma pago
                            </td>
                            <td>
                                <b> {{ $venta->Formapago->forma }} </b>
                            </td>
                            <td>
                                <button id="guardarVta" class="btn btn-light btn-block border">
                                    <i class="fa fa-floppy-o text-primary" aria-hidden="true"></i> Finaliza
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Observaciones</td>
                            <td><b> {{ $venta->observaciones }} </b></td>
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

        <div class="card-body">

            <div class="row mb-2 text-center bg-secondary text-white">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    Nombre del producto
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    Cantidad
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    Precio
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    Descuento
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2">

                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    Total
                </div>
            </div>

            {!! Form::open(['route' => ['detalleventa.insert'], 'id' => 'detalleVta']) !!}

            <div class="row mb-2 text-center">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    {!! Form::select('producto', $producto, null, ['id' => 'producto', 'class' => 'select2 form-control', 'placeholder' => 'SELECCIONE']) !!}
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    {!! Form::number('cantidad', 0, ['id' => 'cantidad', 'class' => 'form-control btn-sm text-center']) !!}
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    {!! Form::number('precio', 0, ['id' => 'precio', 'class' => 'form-control btn-sm text-center']) !!}
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">

                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2">

                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    <button id="guardar" class="btn btn-primary" type="button">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            {{ Form::close() }}


            {!! Form::open(['route' => ['venta.ventaContacto', $venta->contacto], 'id' => 'venta']) !!}
            {{ Form::close() }}


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div id="detalleventa">
                        @include('admin.detalleventas.detalle')
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')

    <script>
        var comprobante = '{{ ucwords(strtolower($venta->Tipocomprobante->comprobante)) }}';

        $('#guardarVta').click(function() {

            var total = $('#total').val();

            var id = {{ $venta->id }};
            var tipocomprob = {{ $venta->tipocomprobante }};
            var descuento = $('#descuento').val();
            descuento > 0 ? descuento = descuento / 100 : descuento = 0;

            var route = '{{ route('venta.registrarVtaManual') }}';
            var token = $('input[name=_token]').val();

            var direccion = $("#venta").attr('action');

            ymz.jq_confirm({
                title: "&nbsp; Cierra " + comprobante + " ? &nbsp;",
                text: "&nbsp;",
                no_btn: "No",
                yes_btn: "Si",
                no_fn: function() {

                    return false;
                },
                yes_fn: function() {

                    $.ajax({
                        url: route,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            id: id,
                            tipocomprobante: tipocomprob,
                            descuento: descuento
                        },
                        success: function(data) {
                            window.location = direccion;
                        }
                    })
                }
            })
        });

        $('#borrarVta').click(function() {
            ymz.jq_confirm({
                title: "&nbsp; Descarta " + comprobante + " ? &nbsp;",
                text: "&nbsp;",
                no_btn: "No",
                yes_btn: "Si",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {

                    $.ajax({
                        url: '{{ route('venta.destroy') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('input[name=_token]').val()
                        },
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            id: {{ $venta->id }}
                        },

                        success: function(data) {

                            console.log(data)

                            var texto = 'Aguarde';
                            toastr.info(texto, 'Descartando venta ... ', {
                                closeButton: false
                            });
                            setTimeout(() => {
                                window.location =
                                    '{{ route('venta.ventaContacto', [$venta->contacto]) }}';
                            }, 1500);
                        }
                    })
                }
            })
        });


        $('#guardar').click(function() {

            var venta = {{ $venta->id }};
            var tipocomprob = {{ $venta->tipocomprobante }};
            var producto = $('#producto').val();
            var cantidad = $('#cantidad').val();
            var precio = $('#precio').val();
            var descuento = $('#descuento').val();

            descuento > 0 ? descuento = descuento / 100 : descuento = 0;

            var route = '{{ route('detalleventa.insert') }}';
            var token = $('input[name=_token]').val();

            if (producto != null) {

                if (cantidad == 0) {

                    var texto = 'Complete Cantidad';
                    ymz.jq_alert({
                        title: "Información",
                        text: texto,
                        ok_btn: "Ok",
                        close_fn: null
                    });
                } else {

                    $.ajax({

                        url: route,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            venta: venta,
                            tipocomprobante: tipocomprob,
                            producto: producto,
                            cantidad: cantidad,
                            precio: precio,
                            descuento: descuento
                        },
                        success: function(data) {

                            $("#detalleventa").html(data);
                            $('select#producto').val(0).select2();
                            $('#cantidad').val(0);
                            $('#precio').val(0);
                        }
                    });
                }
            } else {

                var texto = 'Complete producto';
                ymz.jq_alert({
                    title: "Información",
                    text: texto,
                    ok_btn: "Ok",
                    close_fn: null
                });
            }

        });

        function borrarReg(id) {

            var route = '{{ route('detalleventa.destroy') }}';
            var token = $('input[name=_token]').val();
            var venta = {{ $venta->id }};

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    venta: venta
                },

                success: function(data) {
                    $("#detalleventa").html(data);
                }
            });
        }

        $('#producto').change(function() {

            var token = $('input[name=_token]').val();
            var id = $('#producto option:selected').val();
            var route = '{{ route('detalleventa.getproducto') }}';

            $.ajax({

                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(data) {
                    $('#precio').val(data.precio);
                    $('#cantidad').val(1);
                    $('#cantidad').select();
                },

            });
        });
    </script>
@stop
