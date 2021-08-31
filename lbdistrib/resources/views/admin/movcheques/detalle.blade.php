<div class="table-responsive">
    <table class="table small table-hover text-center" id="cheques" style="font-size: smaller">
        <thead>
            <tr>
                <td>Nro</td>
                <td>Fecha registro</td>
                <td>Fecha cobro</td>
                <td>Recibido de</td>
                <td>Importe</td>
                <td>Banco</td>
                <td>Cobrado</td>
                <td>Observacion</td>
                <td>Fecha pago</td>
                <td>Reseña de pago</td>
                <td>Borrar </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($cheques as $cheque)
                <tr id="fila{{ $cheque->id }}">
                    <td>
                        <a href="{{ route('cheque.edit', $cheque->id) }}">
                            {{ $cheque->nrocheque }}
                        </a>
                    </td>
                    <td>{{ date('d-m-Y', strtotime($cheque->created_at)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($cheque->fechacobro)) }}</td>
                    <td>
                        @if ($cheque->Contacto)
                            {{ $cheque->Contacto->nombreempresa }}
                        @endif
                    </td>
                    <td style="text-align: right"> {{ number_format($cheque->importe, 2, ',', '.') }}</td>
                    <td>{{ $cheque->Banco->nombre }}</td>
                    <td> <input type="checkbox" @if ($cheque->cobrado == 1) checked @endif> </td>
                    <td>{{ substr($cheque->observacion, 0, 100) }}</td>
                    <td>
                        @if ($cheque->fechapago)
                            {{ date('d-m-Y', strtotime($cheque->fechapago)) }}
                        @endif
                    </td>
                    <td>{{ substr($cheque->observacionpago, 0, 100) }}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-link" id="eliminar" name="eliminar"
                            value="{{ $cheque->id }}"
                            onclick="eliminarRegistro(this.value, '{{ route('cheque.destroy') }}')">
                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
