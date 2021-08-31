<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <table id="detalle-cheques" class="table table-hover text-center table-borderless table-condensed small mb-0">
            <tbody>
                @foreach ($detallecheque as $detalle)
                    <tr>
                        <td style="width: 15%">{{ $detalle->nrocheque }}</td>
                        <td style="width: 15%">{{ date('d-m-Y', strtotime($detalle->fechacobro)) }}</td>
                        <td style="width: 15%">{{ $detalle->Banco->nombre }}</td>
                        <td style="width: 15%">{{ $detalle->observacion }}</td>
                        <td style="width: 15%">{{ number_format($detalle->importe, 2, ',', '.') }}</td>
                        <td style="width: 15%">
                            <button class=" btn btn-link" value="{{ $detalle->id }}"
                                onclick="return borrarCheque(this.value, '{{ route('detallecobro.destroyc') }}', {{ $detalle->importe }})">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach

                @if ($detallecheque->count() > 0)
                    <tr>
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%"></td>
                        <td style="width: 15%">Total cheques</td>
                        <td style="width: 15%" class="font-weight-bolder">
                            {{ number_format($detallecheque->sum('importe'), 2, ',', '.') }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
