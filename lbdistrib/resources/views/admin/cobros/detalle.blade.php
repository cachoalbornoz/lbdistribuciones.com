<table id="cobros" class="table table-bordered table-hover small text-center">
    <thead class="bg-secondary text-white">
        <tr>
            <td style="width: 15%">Nro</td>
            <td style="width: 15%">Fecha</td>
            <td style="width: 15%">Razón social</td>
            <td style="width: 15%">Comprobante</td>
            <td style="width: 15%">Nro</td>
            <td style="width: 15%">Total</td>
            <td style="width: 15px"> </td>
        </tr>
    </thead>
    <tbody>
        @foreach ($cobros as $cobro)

            <tr id="fila{{ $cobro->id }}">
                <td>
                    <a href="{{ route('print.comprobante', [$cobro->id, $cobro->tipocomprobante]) }}">
                        {{ $cobro->nro }}
                    </a>
                </td>
                <td> {{ date('d-m-Y', strtotime($cobro->fecha)) }}</td>
                <td>
                    <a href="{{ route('contacto.edit', $cobro->contacto) }}">
                        @if (isset($cobro->Contacto->nombreempresa))
                            {{ $cobro->Contacto->nombreempresa }}
                        @else
                            Info no disponible
                        @endif
                    </a>
                </td>
                <td @if ($cobro->tipocomprobante == 9) class=" text-danger" @endif>
                    {{ $cobro->Tipocomprobante->comprobante }}
                </td>
                <td>
                    {{ $cobro->nro }}
                </td>
                <td @if ($cobro->tipocomprobante == 9) class=" text-danger" @endif>
                    {{ number_format($cobro->total, 2, ',', '.') }}
                </td>
                <td>
                    @if (isset($contacto))
                        <a href="javascript:eliminarCobro({{ $cobro->id }})">
                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b> TOTAL COBRADO </b></td>
            <td><b>{{ number_format($total, 2, ',', '.') }}</b></td>
            <td></td>
        </tr>
    </tfoot>
</table>

<div class="box-footer clearfix">
    {{ $cobros->appends(Request::all())->links() }}
</div>
