<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <table id="pagos" class="table table-striped small table-hover text-center table-borderless">
            <thead>
                <tr class="bg-secondary text-white">
                    <td style="width: 15%">Nro Compra </td>
                    <td style="width: 15%">Fecha </td>
                    <td style="width: 15%">Comprobante </td>
                    <td style="width: 15%">Importe </td>
                    <td style="width: 15%">Pagar</td>
                    <td style="width: 15%">Recibo</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($compras as $compra)
                    <tr>
                        <td>
                            {{ $compra->nro }}
                        </td>
                        <td>
                            <a href="{{ route('detallecompra.show', $compra->id) }}">
                                {{ date('d-m-Y', strtotime($compra->fecha)) }}
                            </a>
                        </td>
                        <td>
                            {{ $compra->Tipocomprobante->comprobante }}
                        </td>
                        <td>
                            @if ($compra->tipocomprobante == 2)
                                <!-- Comprobante presupuesto -->
                                <input type="hidden" id="monto{{ $compra->id }}" name="monto{{ $compra->id }}"
                                    value="{{ $compra->total }}">
                                {{ $compra->total }}
                            @else
                                <!-- Comprobante nota crédito -->
                                <input type="hidden" id="monto{{ $compra->id }}" name="monto{{ $compra->id }}"
                                    value="{{ -$compra->total }}">
                                -{{ $compra->total }}
                            @endif
                        </td>
                        <td>
                            <input type="checkbox" id="check{{ $compra->id }}" name="check{{ $compra->id }}"
                                @if ($compra->pagada == 1) checked @endif value="{{ $compra->id }}"
                                onclick="asociarCompra({{ $compra->id }})" class="chk">
                        </td>
                        <td>
                            {{ $compra->recibo }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border @if ($totalPagado > 0)border-danger @endif">
                    <th></th>
                    <th style="width: 15%"></th>
                    <th style="width: 15%" class="@if ($totalPagado > 0)text-danger @endif">
                        TOTAL A PAGAR
                    </th>
                    <th style="width: 15%" class="@if ($totalPagado > 0)text-danger @endif">
                        {{ number_format($totalPagado, 2) }}
                    </th>
                    <th style="width: 15%"></th>
                    <th style="width: 15%"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
