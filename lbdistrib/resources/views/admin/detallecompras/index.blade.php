@extends('base.base')

@section('title', 'Detalle compras')

@section('breadcrumb')
    {!! Breadcrumbs::render('compra.detalle', $compra) !!}
@stop

@section('content')

    <div class="card">
        <div
            class="card-body border 
                             @if ($compra->tipocomprobante == 8) border-danger @else
            border-primary @endif">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <table class="table small table-borderless">
                        <tr>
                            <td>
                                @if ($compra->tipocomprobante == 8)
                                    <span class="text-danger">
                                        {{ ucwords($compra->Tipocomprobante->comprobante) }}
                                    </span>
                                @else
                                    {{ ucwords($compra->Tipocomprobante->comprobante) }}
                                @endif
                            </td>
                            <td>
                                <strong>{{ $compra->Proveedor->nombreempresa }} - {!! $compra->Proveedor->nombreCompleto() !!}</strong>
                            </td>
                            <td style=" width: 15%">Fecha</td>
                            <td style=" width: 15%"><b> {{ date('d-m-Y', strtotime($compra->fecha)) }} </b></td>
                            <td style=" width: 15%">
                                <button id="borrarCpra" class="btn btn-light btn-block border">
                                    <i class="fa fa-trash text-danger" aria-hidden="true"></i> Anula
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Nro
                            </td>
                            <td>
                                <b> {{ $compra->nro }} </b>
                            </td>
                            <td>
                                Forma pago
                            </td>
                            <td>
                                <b> {{ $compra->Formapago->forma }}</b>
                            </td>
                            <td>
                                <button id="guardarCpra" class="btn btn-light btn-block border">
                                    <i class="fa fa-floppy-o text-primary" aria-hidden="true"></i> Finaliza
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Observaciones</td>
                            <td><b> {{ $compra->observaciones }} </b></td>
                            <td></td>
                            <td></td>
                            <td></td>
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
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    Otro desc
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    IVA
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    Subtotal
                </div>
            </div>
            <div class="row text-center">
                <div class="col-xs-12 col-sm-6 col-lg-6 text-left">
                    {!! Form::select('producto', $producto, null, ['id' => 'producto', 'class' => 'select2 form-control', 'placeholder' => 'Seleccione producto', 'autofocus' => 'true']) !!}
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    {!! Form::number('cantidad', 0, ['id' => 'cantidad', 'class' => 'form-control text-center']) !!}
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    {!! Form::number('precio', 0, ['id' => 'precio', 'class' => 'form-control text-center', 'step' => 'any']) !!}
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    {!! Form::number('descuento', 0, ['id' => 'descuento', 'class' => 'form-control text-center', 'step' => 'any']) !!}
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    {!! Form::number('descuento1', 0, ['id' => 'descuento1', 'class' => 'form-control text-center', 'step' => 'any']) !!}
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    {!! Form::number('iva', 0, ['id' => 'iva', 'class' => 'form-control text-center', 'step' => 'any']) !!}
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    <button id="guardar" class=" btn btn-outline-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div id="detallecompra">
                @include('admin.detallecompras.detalle')
            </div>

        </div>
    </div>

@endsection

@section('js')

    <script>
        var comprobante = '{{ ucwords(strtolower($compra->Tipocomprobante->comprobante)) }}';

        $('#guardarCpra').click(function() {

            var total = $('#total').val();

            var id = {{ $compra->id }};
            var tipocomprob = {{ $compra->tipocomprobante }};

            var route = '{{ route('compra.registrarCpra') }}';
            var token = $('input[name=_token]').val();

            var direccion = '{{ route('compra.compraProveedor', $compra->proveedor) }}'

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
                        },
                        success: function(data) {

                            //console.log(data)

                            var texto = 'Aguarde';
                            toastr.info(texto, 'Guardando compra ... ', {
                                closeButton: false
                            });

                            setTimeout(() => {
                                window.location = direccion;
                            }, 1500);
                        }
                    })
                }
            })
        });

        $('#borrarCpra').click(function() {

            var id = {{ $compra->id }};
            var ruta = '{{ route('compra.destroy') }}';
            var token = $('input[name=_token]').val();

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
                        url: ruta,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            id: id
                        },

                        success: function(response) {
                            window.location = "{{ route('compra.index') }}";
                        }
                    })
                }
            })
        });

        $('#guardar').click(function() {

            let compra = {{ $compra->id }};
            let tipocomprob = {{ $compra->tipocomprobante }};
            let producto = $('#producto').val();
            let nombre = $('#producto option:selected').text();
            let cantidad = $('#cantidad').val();
            let precio = $('#precio').val();
            let descuento = ($('#descuento').val() > 0) ? $('#descuento').val() : 0;
            let descuento1 = ($('#descuento1').val() > 0) ? $('#descuento1').val() : 0;
            let iva = ($('#iva').val() > 0) ? $('#iva').val() : 0;

            let total = $('#total').val();

            let route = '{{ route('detallecompra.insert') }}';
            let token = $('input[name=_token]').val();

            if (producto != null) {

                if (cantidad == 0) {

                    let texto = 'Complete Cantidad';
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
                            compra,
                            producto,
                            cantidad,
                            precio,
                            descuento,
                            descuento1,
                            iva
                        },
                        success: function(data) {
                            $("#detalleCpra").trigger("reset");
                            $('#detallecompra').html(data);
                        }
                    });
                }

            } else {

                var texto = 'Seleccione un producto';
                ymz.jq_alert({
                    title: "Información",
                    text: texto,
                    ok_btn: "Ok",
                    close_fn: null
                });
            }

        });

        $(document).on('keydown', function(e) {
            if (e.keyCode === 13) { // ENTER
                return false;
            }
            if (e.keyCode === 107) { // TECLA '+'
                $("#guardar").trigger("click");
            }
        });

        $('#producto').change(function() {

            var token = $('input[name=_token]').val();
            var id = $('#producto option:selected').val();
            var route = '{{ route('detallecompra.getproducto') }}';

            $.ajax({

                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id
                },
                success: function(data) {

                    $('#precio').val(data.precio);
                    $('#cantidad').val(1);
                    $('#cantidad').select();
                },

            });
        });

        function borrarReg(id) {

            var route = '{{ route('detallecompra.destroy') }}';
            var token = $('input[name=_token]').val();
            var compra = {{ $compra->id }};

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id,
                    compra
                },

                success: function(data) {

                    $('#detallecompra').html(data);
                }
            });
        }
    </script>
@stop
