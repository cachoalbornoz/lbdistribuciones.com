@extends('base.base')

@section('title', 'Detalle pago')

@section('breadcrumb')
    {!! Breadcrumbs::render('pago.detalle', $pago) !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-lg-10">
                    <h5>
                        {{ ucwords(strtolower($pago->Tipocomprobante->comprobante)) }}
                    </h5>
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    <a href="{{ route('print.comprobante', [$pago->id, $pago->tipocomprobante]) }}"
                        class="btn btn-success">
                        <i class="fa fa-print" aria-hidden="true"> </i>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    <a href="{{ route('contacto.show', [$pago->contacto]) }}" class="btn btn-secondary">
                        Cerrar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="table-responsive">
                        <table class="table small table-borderless" style="font-size: smaller">
                            <tr>
                                <td style="width: 15%">Razón social</td>
                                <td>
                                    <b> {{ $pago->Proveedor->nombreempresa . ' ' . $pago->Proveedor->nombreCompleto() }}
                                    </b>
                                </td>
                                <td style="width: 15%">
                                    Fecha
                                </td>
                                <td>
                                    <b> {{ date('d-m-Y', strtotime($pago->fecha)) }} </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td><b> {{ $pago->observaciones }} </b></td>
                                <td>Comprobante</td>
                                <td><b>{{ $pago->Comprobante }}</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Detalle del pago
        </div>
        <div class="card-body">

            <div class="total">
                @include('admin.detallepagos.detalleresumen')
            </div>
            <div class="table-responsive">
                <table class="table small table-bordered" style="font-size: smaller">
                    <thead>
                        <tr class="bg-secondary text-white">
                            <td>Fecha </td>
                            <td>Nro Tipo Comprobante </td>
                            <td class="text-center" style=" width: 15%"> $ Importe </td>
                            <td class="text-center" style=" width: 10%"> Imputado</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $pago)
                            <tr id="pago{{ $pago->id }}">
                                <td>
                                    <a href="{{ route('detallepago.show', $pago->id) }}">
                                        {{ date('d-m-Y', strtotime($pago->fecha)) }}
                                    </a>
                                </td>
                                <td> {{ $pago->Tipocomprobante->comprobante }} {{ $pago->nro }} </td>
                                <td class="text-center">
                                    @if ($pago->tipocomprobante == 2)
                                        {{ $pago->total }}
                                    @else
                                        - {{ $pago->total }}
                                    @endif
                                </td>
                                <td class="text-center"> <input type="checkbox" checked> </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection


@section('js')

    <script>
        var totalcobrado = {{ $totalCobrado }};

        function guardarEfectivo() {

            var pago = $('#pago').val();
            var tipocomprob = {{ $pago->tipocomprobante }};
            var tipopago = 1;
            var importe = $('#importe').val();
            var concepto = $('#concepto').val();
            var recargo = $('#recargo').val();

            var route = '{{ route('detallepago.insert') }}';
            var token = $('input[name=_token]').val();

            if (importe == 0) {

                var texto = 'Complete importe';
                ymz.jq_alert({
                    title: "Información",
                    text: texto,
                    ok_btn: "Ok",
                    close_fn: null
                });

            } else {

                if (recargo < 1) {
                    var rec = (1 - recargo);
                } else {
                    var rec = recargo;
                }

                $.ajax({

                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        pago: pago,
                        tipopago: tipopago,
                        tipocomprobante: tipocomprob,
                        concepto: concepto,
                        importe: importe,
                        recargo: recargo,
                        totalcobrado: totalcobrado
                    },
                    success: function(data) {

                        $(".efectivo").html(data.efectivo);
                        $(".total").html(data.total);

                        $('#importe').val(0);
                    }
                });
            }
        }

        function borrarEfectivo(id, ruta) {

            var token = $('input[name=_token]').val();
            var pago = $('#pago').val();
            $.ajax({

                url: ruta,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    pago: pago,
                    totalcobrado: totalcobrado
                },

                success: function(data) {

                    $(".efectivo").html(data.efectivo);
                    $(".total").html(data.total);
                }
            });
        }

        $('#guardarCheque').click(function() {

            var pago = {{ $pago->id }};
            var tipocomprob = {{ $pago->tipocomprobante }};
            var importe = $('#importec').val();
            var nro = $('#nroc').val();
            var fecha = $('#fechac').val();
            var banco = $('#banco').val();
            var nombre = $('#banco option:selected').text();
            var observacion = $('#observacionesc').val();

            var route = '{{ route('detallepago.insertc') }}';
            var token = $('input[name=_token]').val();

            if (importe == 0) {
                var texto = 'Complete importe cheque';
                ymz.jq_alert({
                    title: "Información",
                    text: texto,
                    ok_btn: "Ok",
                    close_fn: null
                });
            } else {
                if (nro == 0) {
                    var texto = 'Complete nro cheque';
                    ymz.jq_alert({
                        title: "Información",
                        text: texto,
                        ok_btn: "Ok",
                        close_fn: null
                    });
                } else {
                    if (fecha == 0) {
                        var texto = 'Complete fecha cheque';
                        ymz.jq_alert({
                            title: "Información",
                            text: texto,
                            ok_btn: "Ok",
                            close_fn: null
                        });
                    } else {
                        if (!banco) {
                            var texto = 'Complete banco cheque';
                            ymz.jq_alert({
                                title: "Información",
                                text: texto,
                                ok_btn: "Ok",
                                close_fn: null
                            });
                        } else {

                            $("#detalleCobroCheque").trigger("reset");

                            $.ajax({
                                url: route,
                                headers: {
                                    'X-CSRF-TOKEN': token
                                },
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    idcomprobante: pago,
                                    tipocomprobante: tipocomprob,
                                    nrocheque: nro,
                                    fechapago: fecha,
                                    banco: banco,
                                    importe: importe,
                                    observacion: observacion,
                                    totalcobrado: totalcobrado
                                },
                                success: function(data) {

                                    $(".cheque").html(data.cheque);
                                    $(".total").html(data.total);

                                    $("#form-cheque").trigger('reset');
                                }
                            });
                        }
                    }
                }
            }
        })

        function borrarCheque(id, ruta) {

            var token = $('input[name=_token]').val();
            var pago = $('#pago').val();

            $.ajax({

                url: ruta,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    idcomprobante: pago,
                    totalcobrado: totalcobrado
                },

                success: function(data) {

                    $(".cheque").html(data.cheque);
                    $(".total").html(data.total);
                }
            });
        }
    </script>
@stop
