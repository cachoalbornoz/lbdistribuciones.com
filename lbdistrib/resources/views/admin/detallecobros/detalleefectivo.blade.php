<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <table class="table table-hover text-center table-borderless table-condensed small mb-0">
            <tbody>
                @foreach ($detallecobro as $detalle)
                    <tr id="fila{{ $detalle->id }}">
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%">
                            <a href="javascript:void(0)" class="btn-link"
                                onclick="return borrarEfectivo({{ $detalle->id }}, '{{ route('detallecobro.destroy') }}', {{ $detalle->subtotal }}, 1) ">
                                <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td style="width: 15%">
                            Total efectivo
                        </td>
                        <td style="width: 15%" class=" font-weight-bolder">
                            {{ number_format($detalle->subtotal, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                @foreach ($detalleTrans as $detalle)
                    <tr id="fila{{ $detalle->id }}">
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%">
                            <a href="javascript:void(0)" class="btn-link"
                                onclick="return borrarEfectivo({{ $detalle->id }}, '{{ route('detallecobro.destroy') }}', {{ $detalle->subtotal }}, 3) ">
                                <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td style="width: 15%">
                            Total transferencia
                        </td>
                        <td style="width: 15%" class=" font-weight-bolder">
                            {{ number_format($detalle->subtotal, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
