<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <table class="table table-hover text-center small table-borderless">
            <tbody>
                @foreach ($detallepago as $detalle)
                    <tr id="fila{{ $detalle->id }}" class="bg-light">
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%">
                            <a href="javascript:void(0)" class="btn-link"
                                onclick="return borrarEfectivo({{ $detalle->id }}, '{{ route('detallepago.destroy') }}', {{ $detalle->subtotal }}, 1) ">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class=" font-weight-bolder" style="width: 15%">
                            Total {{ $detalle->concepto }}
                        </td>
                        <td style="width: 15%">
                            {{ number_format($detalle->subtotal, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach

                @foreach ($detalleTrans as $detalle)
                    <tr id="fila{{ $detalle->id }}" class="bg-light">
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%">
                            <a href="javascript:void(0)" class="btn-link"
                                onclick="return borrarEfectivo({{ $detalle->id }}, '{{ route('detallepago.destroy') }}', {{ $detalle->subtotal }}, 3) ">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td class=" font-weight-bolder" style="width: 15%">
                            Total {{ $detalle->concepto }}
                        </td>
                        <td style="width: 15%">
                            {{ number_format($detalle->subtotal, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
