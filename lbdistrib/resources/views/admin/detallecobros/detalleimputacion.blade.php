<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <table id="ventas" class="table table-striped small table-hover table-condensed text-center table-borderless">
            <thead>
                <tr class="bg-secondary text-white">
                    <td style="width: 15%">Nro Venta </td>
                    <td style="width: 15%">Fecha </td>
                    <td style="width: 15%">Comprobante </td>
                    <td style="width: 15%">Importe </td>
                    <td style="width: 15%">Imputar</td>
                    <td style="width: 15%">Recibo</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>
                            {{ $venta->nro }}
                        </td>
                        <td>
                            <a href="{{ route('detalleventa.show', $venta->id) }}">
                                {{ date('d-m-Y', strtotime($venta->fecha)) }}
                            </a>
                        </td>
                        <td>
                            {{ $venta->Tipocomprobante->comprobante }}
                        </td>
                        <td>
                            @if ($venta->tipocomprobante == 2)
                                <!-- Comprobante presupuesto -->
                                <input type="hidden" id="monto{{ $venta->id }}" name="monto{{ $venta->id }}"
                                    value="{{ $venta->total }}">
                                {{ $venta->total }}
                            @else
                                <!-- Comprobante nota crédito -->
                                <input type="hidden" id="monto{{ $venta->id }}" name="monto{{ $venta->id }}"
                                    value="{{ -$venta->total }}">
                                -{{ $venta->total }}
                            @endif
                        </td>
                        <td>
                            <input type="checkbox" id="check{{ $venta->id }}" name="check{{ $venta->id }}"
                                @if ($venta->pagada == 1) checked @endif value="{{ $venta->id }}"
                                onclick="asociarVenta({{ $venta->id }})" class="chk">
                        </td>
                        <td>
                            {{ $venta->recibo }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border @if ($totalCobrado > 0)border-danger @endif">
                    <th style="width: 15%"></th>
                    <th style="width: 15%"></th>
                    <th style="width: 15%" class="@if ($totalCobrado > 0)text-danger @endif">
                        TOTAL A COBRAR
                    </th>
                    <th style="width: 15%" class="@if ($totalCobrado > 0)text-danger @endif">
                        {{ $totalCobrado }}
                    </th>
                    <th style="width: 15%"></th>
                    <th style="width: 15%"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
