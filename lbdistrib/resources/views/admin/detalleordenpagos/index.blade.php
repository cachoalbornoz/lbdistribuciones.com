@extends('base.base')

@section('title', 'Detalle pago')

@section('breadcrumb')
{!! Breadcrumbs::render('pago.detalle', $pago) !!}
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row mb-4">
            <div class="col-xs-12 col-md-4 col-lg-4">
                {{ ucwords($pago->Tipocomprobante->comprobante) }}
                Nro <b> {{ $pago->nro }} </b> :: <b>{{ $pago->Proveedor->nombreempresa }} </b>
                {{ $pago->Proveedor->nombreCompleto() }}
            </div>
            <div class="col-xs-12 col-sm-2 col-lg-2">
                Fecha :: <b> {{ date('d-m-Y', strtotime($pago->fecha)) }}</b>
            </div>
            <div class="col-xs-12 col-md-4 col-lg-4">
                <input type="hidden" id="aFavor" name="aFavor" value="{{ $pago->Proveedor->remanente }}">
                Saldo favor :: <span class=" font-weight-bolder"> {{ $pago->Proveedor->remanente }}</span>
            </div>
            <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                <a href="#" onclick="javascript:cerrarOrden({{ $pago->id }})" class="btn btn-outline-info btn-sm" title="Guardar">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                </a>
            </div>
            <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                <a href="#" onclick="javascript:anular({{ $pago->id }})" class="btn btn-outline-danger btn-sm" title="Anula">
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
                    <input type="number" id="totalEfectivo" name="totalEfectivo" disabled value="{{ $totalEfectivo }}" class="form-control text-center font-weight-bolder">
                </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                <div class="input-group-prepend">
                    <span class=" input-group-text">
                        Cheques
                    </span>
                    <input type="number" id="totalCheque" name="totalCheque" disabled value="{{ $totalCheque }}" class="form-control text-center font-weight-bolder">
                </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                <div class="input-group-prepend">
                    <span class=" input-group-text">
                        Transferencia
                    </span>
                    <input type="number" id="totalTransferencia" name="totalTransferencia" disabled value="{{ $totalTransferencia }}" class="form-control text-center font-weight-bolder">
                </div>
            </div>
            <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                <div class="input-group-prepend">
                    <input type="hidden" id="Valores" name="Valores" value="0">
                </div>
            </div>
            <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                <input type="hidden" id="inputado" name="inputado" value="{{ $totalAutorizado }}">
            </div>
            <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                <span class="form-control text-center bg-danger text-white" id="txtPendiente">
                    Falta
                </span>
            </div>
            <div class="col-xs-12 col-sm-2 col-lg-2 text-center">
                <input type="number" id="pendiente" name="pendiente" value="0" class=" form-control text-center">
            </div>
        </div>
    </div>

    <div class="card-body">

        {!! Form::hidden('pago', $pago->id, ['id' => 'pago', 'class' => 'form-control']) !!}

        <div class="imputacion">
            @include('admin.detalleordenpagos.detalleimputacion')
        </div>

        <div class="cheque">
            @include('admin.detalleordenpagos.detallecheque')
        </div>

        <div class="efectivo">
            @include('admin.detalleordenpagos.detalleefectivo')
        </div>
    </div>
</div>


@endsection

@section('js')

<script>
    let comprobante = '{{ ucwords(strtolower($pago->Tipocomprobante->comprobante)) }}';

        // Calcular total 
        var totalPagado = 0;
        $("input:checkbox[class=chk]:checked").each(function() {
            totalPagado = totalPagado + parseFloat($('#monto' + $(this).val()).val());
        });

        const actualizar = () => {
            var nuevoValor =
                parseFloat($("#totalEfectivo").val()) +
                parseFloat($("#totalCheque").val()) +
                parseFloat($("#totalTransferencia").val())

            $("#Valores").val(nuevoValor.toFixed(2));
            var nuevoPendiente = parseFloat($("#Valores").val()) - parseFloat($("#inputado").val());
            $("#pendiente").val(nuevoPendiente.toFixed(2));

            if (nuevoPendiente > 0) {
                $("#txtPendiente").removeClass('bg-danger').addClass('bg-success').html('Excedido');
                $("#pendiente").removeClass('text-danger').addClass('text-success');
            } else {
                if (nuevoPendiente < 0) {
                    $("#txtPendiente").removeClass('bg-success').addClass('bg-danger').html('Falta');
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

        const cerrarOrden = (id) => {

            var pendiente = $("#pendiente").val();

            // Revisar si no cargó nada
            if ($("#Valores").val() == 0) {
                ymz.jq_alert({
                    title: "Atención",
                    text: `No cargó importe para pagar $<b>${Math.abs($("#pendiente").val())}</b>`,
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
                    text: `Está inputando ${numberOfChecked} recibos y pero aún falta $<b>${Math.abs(pendiente)}</b>`,
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

                    var texto = 'Aguarde';
                    toastr.info(texto, 'Actualizando orden ... ', {
                        closeButton: false
                    });

                    setTimeout(() => {
                        window.location =
                            '{{ route('pago.pagoProveedor', [$pago->proveedor]) }}';
                    }, 3000);


                }
            })
        }

        const asociarCheque = (chequeId) => {

            $.ajax({
                url: '{{ route('detallepago.insertc') }}',
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    chequeId,
                    pago: {{ $pago->id }},
                },
                success: function(data) {
                    $(".cheque").html(data.vistaCheques);
                    $("#totalCheque").val(data.totalCheque)
                    actualizar()

                }
            });
        }

        const asociarCompra = (compraId) => {

            var route = '{{ route('detalleordenpago.autorizacion') }}';
            var token = $('input[name=_token]').val();
            var pago = $('#pago').val();
            var totalPagado = 0;

            $("input:checkbox[class=chk]:checked").each(function() {
                totalPagado = totalPagado + parseFloat($('#monto' + $(this).val()).val());
            });

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    pago,
                    compraId,
                    totalPagado
                },
                success: function(data) {
                    $(".imputacion").html(data.imputacion);
                    $("#inputado").val(totalPagado.toFixed(2));
                    actualizar();
                }
            });
        }

        const guardarEfectivo = (tipopago) => {
            var pago = $('#pago').val();
            var tipocomprob = {{ $pago->tipocomprobante }};
            var tipopago = tipopago;
            var importe = (tipopago == 1) ? $('#importeEfectivo').val() : $('#importeTransferencia').val();
            var txtImporte = (tipopago == 1) ? 'efectivo' : 'transferencia';
            importe = parseFloat(importe).toFixed(2);
            var concepto = (tipopago == 1) ? 'Efectivo' : 'Transferencia';
            var recargo = 0;

            var route = '{{ route('detallepago.insert') }}';
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
                        pago,
                        tipopago,
                        tipocomprobante: tipocomprob,
                        concepto,
                        importe,
                        recargo
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
            var pago = $('#pago').val();
            $.ajax({
                url: ruta,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    id,
                    pago
                },
                success: function(data) {
                    $(".efectivo").html(data.vistaEfectivo);
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
                    window.location = '{{ route('pago.anular', [$pago->id]) }}';
                }
            })
        }
</script>
@stop