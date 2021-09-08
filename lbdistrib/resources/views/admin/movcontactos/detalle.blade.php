<table id="movcontactos" class="table table-bordered table-hover small text-center">
    <thead class="bg-secondary text-white">
        <td style="width: 5%">Nro</td>
        <td style="width: 15%">Fecha</td>
        <td style="width: 15%">Concepto</td>
        <td style="width: 15%">Nro</td>
        <td style="width: 15%">Debe</td>
        <td style="width: 15%">Haber</td>
        <td style="width: 15%">Saldo</td>
        <th style="width: 5%"></th>
    </thead>
    <tbody>
        @foreach ($movcontactos as $movcontacto)
            <tr id="fila{{ $movcontacto->id }}" @if ($loop->first) class=" text-bold"  @endif>
                <td>
                    @if ($movcontacto->idcomprobante == 0)
                        {{ $movcontacto->nro }}
                    @else
                        <a
                            href="{{ route('print.comprobante', [$movcontacto->idcomprobante, $movcontacto->tipocomprobante]) }}">
                            {{ $movcontacto->nro }}
                        </a>
                    @endif
                </td>
                <td>{{ date('d-m-Y', strtotime($movcontacto->fecha)) }}</td>
                <td>{{ $movcontacto->concepto }}</td>
                <td>{{ $movcontacto->nro }}</td>
                <td> {{ number_format($movcontacto->debe, 2, ',', '.') }}</td>
                <td> {{ number_format($movcontacto->haber, 2, ',', '.') }}</td>
                <td @if ($movcontacto->saldo == 0)
                    class = "text-green"
                @else
                    @if ($movcontacto->saldo < 0)
                        class="text-danger"
                    @endif
        @endif
        > {{ number_format($movcontacto->saldo, 2, ',', '.') }}
        </td>
        <td>
            <a href="javascript:eliminarMovContacto({{ $movcontacto->id }})">
                <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
            </a>
        </td>
        </tr>
        @endforeach
    </tbody>
</table>
