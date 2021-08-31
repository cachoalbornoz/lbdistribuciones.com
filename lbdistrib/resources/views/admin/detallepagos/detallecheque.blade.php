<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <table id="cheques" class="table table-hover text-center table-borderless small mb-0">
            <thead>
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
                                <a href="javascript:void(0)" class="btn btn-link" onclick="return guardarEfectivo(1);">
                                    <i class="fa fa-floppy-o" aria-hidden="true" id="btnEfectivo"></i>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        Transferencia
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            {!! Form::number('importeTransferencia', 0, ['id' => 'importeTransferencia', 'class' => 'form-control text-center', 'step' => 'any']) !!}
                            <div class="input-group-append">
                                <a href="javascript:void(0)" class="btn btn-link" onclick="return guardarEfectivo(3);">
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
                    <td>Importe </td>
                    <td></td>
                    <td>Recibo</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($cheques as $cheque)
                    <tr>
                        <td>{{ $cheque->nrocheque }}</td>
                        <td>{{ date('d-m-Y', strtotime($cheque->fechacobro)) }}</td>
                        <td>{{ $cheque->Banco->nombre }}</td>
                        <td>{{ $cheque->importe }} </td>
                        <td>
                            <input type="checkbox" id="check{{ $cheque->id }}" name="check{{ $cheque->id }}"
                                @if ($cheque->pagado == 1) checked @endif value="{{ $cheque->id }}"
                                onclick="asociarCheque({{ $cheque->id }})" class="chkcheque">
                        </td>
                        <td>{{ $cheque->recibo }}</td>
                    </tr>
                @endforeach

                @foreach ($detallecheque as $detalle)
                    <tr>
                        <td>{{ $detalle->nrocheque }} </td>
                        <td>{{ date('d-m-Y', strtotime($detalle->fechacobro)) }} </td>
                        <td>{{ $detalle->Banco->nombre }} </td>
                        <td>{{ number_format($detalle->importe, 2, ',', '.') }} </td>
                        <td>
                            <input type="checkbox" id="check{{ $detalle->id }}" name="check{{ $detalle->id }}"
                                @if ($detalle->pagado == 1) checked @endif value="{{ $detalle->id }}"
                                onclick="asociarCheque({{ $detalle->id }})" class="chkcheque">
                        </td>
                        <td>{{ $detalle->recibo }}</td>
                    </tr>
                @endforeach
                <tr class="bg-light">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class=" font-weight-bolder">Total cheques</td>
                    <td>{{ number_format($detallecheque->sum('importe'), 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
