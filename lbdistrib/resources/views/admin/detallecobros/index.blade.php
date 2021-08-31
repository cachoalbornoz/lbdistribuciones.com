@extends('base.base')

@section('title', 'Detalle cobro')

@section('breadcrumb')
    {!! Breadcrumbs::render('cobro.detalle', $cobro) !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row mb-4">
                <div class="col-xs-12 col-sm-4 col-lg-4">
                    @if ($cobro->tipocomprobante == 9)
                        <span class="text-danger">
                            {{ ucwords($cobro->Tipocomprobante->comprobante) }}
                        </span>
                    @else
                        {{ ucwords($cobro->Tipocomprobante->comprobante) }}
                    @endif
                    Nro <b> {{ $cobro->nro }} </b> :: <b>{{ $cobro->Contacto->nombreempresa }}</b> -
                    {{ $cobro->Contacto->nombreCompleto() }}

                </div>

                <div class="col-xs-12 col-sm-2 col-lg-2">
                    Fecha :: <b> {{ date('d-m-Y', strtotime($cobro->fecha)) }}</b>
                </div>

                <div class="col-xs-12 col-sm-2 col-lg-2">
                    <input type="hidden" id="aFavor" name="aFavor" value="{{ $cobro->Contacto->remanente }}">
                    Saldo favor :: <span class=" font-weight-bolder"> {{ $cobro->Contacto->remanente }}</span>
                </div>

                <div class="col-xs-12 col-sm-2 col-lg-2">

                </div>

                <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                    <a href="#" onclick="javascript:cerrarCobro({{ $cobro->id }})"
                        class="btn btn-outline-info btn-sm guardar" title="Guardar">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                    <a href="#" onclick="javascript:anular()" class="btn btn-outline-danger btn-sm" title="Anula">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                    <div class="input-group-prepend">
                        <span class=" input-group-text">
                            Efectivo
                        </span>
                        <input type="number" id="totalEfectivo" name="totalEfectivo" disabled value="{{ $totalEfectivo }}"
                            class="form-control text-center font-weight-bolder ">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                    <div class="input-group-prepend">
                        <span class=" input-group-text">
                            Cheques
                        </span>
                        <input type="number" id="totalCheque" name="totalCheque" disabled value="{{ $totalCheque }}"
                            class="form-control text-center font-weight-bolder">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                    <div class="input-group-prepend">
                        <span class=" input-group-text">
                            Transferencia
                        </span>
                        <input type="number" id="totalTransferencia" name="totalTransferencia" disabled
                            value="{{ $totalTransferencia }}" class="form-control text-center font-weight-bolder">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                    <input type="hidden" id="Valores" name="Valores" value="0">
                </div>
                <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                    <input type="hidden" id="inputado" name="inputado" value="{{ number_format($totalCobrado, 2) }}">
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                    <div class="input-group-prepend">
                        <input type="hidden" id="pendiente" name="pendiente" value="0" disabled
                            class="form-control text-center text-danger">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                    <span class="form-control bg-danger text-center text-white" id="txtPendiente">
                        Cobrar $
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="imputacion">
                @include('admin.detallecobros.detalleimputacion')
            </div>

            <div class="carga-pagos">

                {!! Form::hidden('cobro', $cobro->id, ['id' => 'cobro']) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <table id="tipo-pagos" class="table table-hover text-center table-borderless small">
                            <tbody>
                                <tr>
                                    <td style="width: 15%"></td>
                                    <td style="width: 15%"></td>
                                    <td style="width: 15%"></td>
                                    <td style="width: 15%"></td>
                                    <td style="width: 15%">
                                        Efectivo
                                    </td>
                                    <td style="width: 15%">
                                        <div class="input-group input-group-sm">
                                            {!! Form::number('importeEfectivo', 0, ['id' => 'importeEfectivo', 'class' => 'form-control text-center', 'step' => 'any']) !!}
                                            <div class="input-group-append">
                                                <a href="javascript:void(0)" class="btn btn-link"
                                                    onclick="return guardarEfectivo(1);">
                                                    <i class="fa fa-floppy-o" aria-hidden="true" id="btnEfectivo"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 15%"></td>
                                    <td style="width: 15%"></td>
                                    <td style="width: 15%"></td>
                                    <td style="width: 15%"></td>
                                    <td style="width: 15%">
                                        Transferencia
                                    </td>
                                    <td style="width: 15%">
                                        <div class="input-group input-group-sm">
                                            {!! Form::number('importeTransferencia', 0, ['id' => 'importeTransferencia', 'class' => 'form-control text-center', 'step' => 'any']) !!}
                                            <div class="input-group-append">
                                                <a href="javascript:void(0)" class="btn btn-link"
                                                    onclick="return guardarEfectivo(3);">
                                                    <i class="fa fa-floppy-o" aria-hidden="true" id="btnTransferencia"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bg-secondary text-white">
                                    <td>Nro cheque</td>
                                    <td>Fecha </td>
                                    <td>Banco </td>
                                    <td>Observaciones </td>
                                    <td>Importe</td>
                                    <td>Agregar</td>
                                </tr>
                                <tr>
                                    <td>{!! Form::text('nroc', null, ['id' => 'nroc', 'class' => 'form-control text-center']) !!}</td>
                                    <td>{!! Form::date('fechac', Date('Y-m-d'), ['id' => 'fechac', 'class' => 'form-control text-center']) !!}</td>
                                    <td>{!! Form::select('banco', $banco, null, ['id' => 'banco', 'class' => 'form-control text-right', 'placeholder' => 'Seleccione banco ']) !!} </td>
                                    <td>{!! Form::text('observacionesc', '-', ['id' => 'observacionesc', 'class' => 'form-control text-center', 'placeholder' => 'observaciones del cheque ']) !!}</td>
                                    <td>{!! Form::number('importec', 0, ['id' => 'importec', 'class' => 'form-control text-center', 'placeholder' => 'Importe cheque', 'step' => 'any']) !!}</td>
                                    <td>
                                        <a href="javascript:guardarCheque()" id="guardarCheque" class="btn btn-link">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="cheque">
                    @include('admin.detallecobros.detallecheque')
                </div>

                <div class="efectivo">
                    @include('admin.detallecobros.detalleefectivo')
                </div>

            </div>
        </div>
    </div>

@endsection


@section('js')

    <script>
        let comprobante = '{{ ucwords(strtolower($cobro->Tipocomprobante->comprobante)) }}';

        // Calcular total 
        var totalCobrado = 0;
        $("input:checkbox[class=chk]:checked").each(function() {
            totalCobrado = totalCobrado + parseFloat($('#monto' + $(this).val()).val());
        });

        const actualizar = () => {
            var nuevoValor =
                parseFloat($("#totalEfectivo").val()) +
                parseFloat($("#totalCheque").val()) +
                parseFloat($("#totalTransferencia").val())

            $("#Valores").val(nuevoValor.toFixed(2))

            var nuevoPendiente = parseFloat($("#Valores").val()) + parseFloat($("#aFavor").val()) - parseFloat($(
                "#inputado").val());

            $("#pendiente").val(nuevoPendiente.toFixed(2));

            if (nuevoPendiente > 0) {
                $("#txtPendiente").removeClass('bg-danger').addClass('bg-success').html('A favor Cte');
                $("#pendiente").removeClass('text-danger').addClass('text-success');
            } else {
                if (nuevoPendiente < 0) {
                    $("#txtPendiente").removeClass('bg-success').addClass('bg-danger').html('Cobrar $');
                    $("#pendiente").removeClass('text-success').addClass('text-danger');
                } else {
                    $("#txtPendiente").removeClass('bg-success').removeClass('bg-danger').addClass(
                        'bg-secondary').html(
                        'Completo');
                    $("#pendiente").removeClass('text-success').removeClass('text-danger');
                }
            }
        }

        $(document).ready(function() {
            actualizar()
        });

        const asociarVenta = (factura) => {

            var route = '{{ route('detallecobro.imputacion') }}';
            var token = $('input[name=_token]').val();
            var cobro = $('#cobro').val();

            var totalCobrado = 0;

            $("input:checkbox[class=chk]:checked").each(function() {
                totalCobrado = totalCobrado + parseFloat($('#monto' + $(this).val()).val());
            });

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    cobro,
                    factura,
                    totalCobrado
                },
                success: function(data) {
                    $(".imputacion").html(data.imputacion);
                    $("#inputado").val(totalCobrado.toFixed(2));
                    actualizar();
                }
            });
        }

        const cerrarCobro = (id) => {

            var pendiente = $("#pendiente").val();

            // Revisar si no cargó nada
            if ($("#Valores").val() == 0) {
                ymz.jq_alert({
                    title: "Atención",
                    text: `No existe importe a cobrar $<b>${Math.abs($("#Valores").val())}</b>`,
                    ok_btn: "Ok",
                    close_fn: () => {
                        $('#importeEfectivo').select()
                    }
                });
                return false;
            }

            // Revisar si imputó pagos, los pueda cubrir con la suma de Efectivo + Cheques
            var numberOfChecked = $('input:checkbox:checked').length;
            if ((numberOfChecked > 0) && (pendiente < 0)) {
                ymz.jq_alert({
                    title: "Atención",
                    text: `Está inputando ${numberOfChecked} recibos y pero aún falta cobrar $<b>${Math.abs(pendiente)}</b>`,
                    ok_btn: "Ok",
                    close_fn: () => {
                        $('#importeEfectivo').select()
                    }
                });
                return false;
            }

            ymz.jq_confirm({
                title: "Guardar",
                text: "&nbsp; Finaliza imputación del  " + comprobante + " ? &nbsp;",
                no_btn: "No",
                yes_btn: "Si",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {

                    var token = $('input[name=_token]').val();
                    var route = '{{ route('detallecobro.cerrar') }}';

                    $.ajax({
                        url: route,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id,
                            totalCobrado: $("#Valores").val(),
                            saldo: pendiente
                        },
                        success: function(data) {

                            var texto = 'Aguarde';
                            toastr.info(texto, 'Actualizando saldos ... ', {
                                closeButton: false
                            });

                            setTimeout(() => {
                                window.location =
                                    '{{ route('cobro.cobroContacto', [$cobro->contacto]) }}';
                            }, 3000);
                        }
                    });

                }
            })
        }

        const anular = () => {

            ymz.jq_confirm({
                title: "&nbsp; Descarta " + comprobante + " ? &nbsp;",
                text: "&nbsp;",
                no_btn: "No",
                yes_btn: "Si",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {
                    window.location = '{{ route('cobro.anular', [$cobro->id]) }}';
                }
            })
        }

        const guardarEfectivo = (tipopago) => {

            var cobro = $('#cobro').val();
            var tipocomprob = {{ $cobro->tipocomprobante }};
            var tipopago = tipopago;
            var importe = (tipopago == 1) ? $('#importeEfectivo').val() : $('#importeTransferencia').val();
            var txtImporte = (tipopago == 1) ? 'efectivo' : 'transferencia';
            importe = parseFloat(importe).toFixed(2);
            var concepto = (tipopago == 1) ? 'Efectivo' : 'Transferencia';
            var recargo = 0;

            var route = '{{ route('detallecobro.insert') }}';
            var token = $('input[name=_token]').val();

            if (importe == 0) {
                ymz.jq_alert({
                    title: "Atención",
                    text: 'Complete importe ' + txtImporte,
                    ok_btn: "Ok",
                    close_fn: () => {
                        if (tipopago == 1) {
                            $('#importeEfectivo').select()
                        } else {
                            $('#importeTransferencia').select()
                        }
                    }
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
                        cobro,
                        tipopago,
                        tipocomprobante: tipocomprob,
                        concepto,
                        importe,
                        recargo,
                        totalCobrado
                    },
                    success: function(data) {

                        $(".efectivo").html(data.vistaEfectivo);

                        $('#importeEfectivo').val(0);
                        $('#importeTransferencia').val(0);

                        if (tipopago == 1) {
                            $("#totalEfectivo").val(importe)
                        } else {
                            $("#totalTransferencia").val(importe);
                        }
                        actualizar();
                    }
                });
            }
        }

        const borrarEfectivo = (id, ruta, importe, tipopago) => {

            var token = $('input[name=_token]').val();
            var cobro = $('#cobro').val();
            $.ajax({
                url: ruta,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    cobro: cobro,
                    totalCobrado: totalCobrado
                },
                success: function(data) {
                    $(".efectivo").html(data.efectivo);
                    $(".total").html(data.total);
                    if (tipopago == 1) {
                        $("#totalEfectivo").val(0)
                        $("#btnEfectivo").removeClass('d-none');
                    } else {
                        $("#totalTransferencia").val(0)
                        $("#btnTransferencia").removeClass('d-none');
                    }
                    actualizar();
                }
            });
        }

        const guardarCheque = () => {

            var cobro = {{ $cobro->id }};
            var contacto = {{ $cobro->contacto }};
            var tipocomprob = {{ $cobro->tipocomprobante }};
            var importe = $('#importec').val();
            var nro = $('#nroc').val();
            var fecha = $('#fechac').val();
            var banco = $('#banco').val();
            var nombre = $('#banco option:selected').text();
            var observacion = $('#observacionesc').val();

            var route = '{{ route('detallecobro.insertc') }}';
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

                            var nuevoImporte = parseFloat($("#totalCheque").val()) + parseFloat(importe);

                            $("#detalleCobroCheque").trigger("reset");

                            $.ajax({
                                url: route,
                                headers: {
                                    'X-CSRF-TOKEN': token
                                },
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    contacto,
                                    idcomprobante: cobro,
                                    tipocomprobante: tipocomprob,
                                    nrocheque: nro,
                                    fechacobro: fecha,
                                    banco,
                                    importe,
                                    observacion,
                                    totalCobrado
                                },
                                success: function(data) {

                                    $(".cheque").html(data.cheque);
                                    $(".total").html(data.total);
                                    $("#form-cheque").trigger('reset');
                                    $("#totalCheque").val(nuevoImporte)
                                    actualizar()
                                }
                            });
                        }
                    }
                }
            }
        }

        const borrarCheque = (id, ruta, importe) => {

            var token = $('input[name=_token]').val();
            var cobro = $('#cobro').val();

            $.ajax({

                url: ruta,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    idcomprobante: cobro,
                    totalCobrado: totalCobrado
                },

                success: function(data) {

                    $(".cheque").html(data.cheque);
                    $(".total").html(data.total);
                    var nuevoImporte = parseFloat($("#totalCheque").val()) - parseFloat(importe);
                    $("#totalCheque").val(nuevoImporte);
                    actualizar()
                }
            });
        }
    </script>
@stop
