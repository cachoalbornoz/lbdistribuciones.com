@extends('base.base')

@section('title', 'Detalle presupuesto')

@section('breadcrumb')
{!! Breadcrumbs::render('presupuestop.detalle', $presupuesto) !!}
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <h5>Presupuesto</h5>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <table class="table table-borderless" style="font-size: smaller">
                    <tr>
                        <td style="width: 15%">
                            Razón social
                        </td>
                        <td>
                            <b> {{ $presupuesto->Proveedor->nombreempresa }} -
                                {{ $presupuesto->Proveedor->nombreCompleto() }} </b>
                        </td>
                        <td style="width: 15%">
                            Fecha
                        </td>
                        <td>
                            <b>{{ date('d/m/Y', strtotime($presupuesto->fecha)) }} </b>
                        </td>
                        <td class=" text-right">
                            @can('presupuesto.facturado')
                            <a href="{{ route('print.presupuestop', [$presupuesto->id]) }}">
                                <i class="fa fa-print text-success" aria-hidden="true"> </i> Imprimir
                            </a>
                            @endcan
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Observaciones
                        </td>
                        <td>
                            <b> {{ $presupuesto->observaciones }} </b>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <table class="table table-hover table-striped table-bordered" id="tablaDetalle"
                    style="font-size: smaller">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th width="15px">Precio</th>
                            <th width="15px">Descuento</th>
                            <th width="15px">Cantidad</th>
                            <th width="15px">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($detallepresupuesto as $detalle)

                        <tr id="item{{$detalle->id}}">
                            <td class=" text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $detalle->Producto->nombre }}
                            </td>
                            <td class=" text-center">
                                {{ $detalle->precio }}
                            </td>
                            <td class=" text-center">
                                {{ $detalle->descuento *100 }} %
                            </td>
                            <td class=" text-center">
                                {{ $detalle->cantidad }}
                            </td>
                            <td class=" text-right ">
                                {{ number_format($detalle->subtotal,2,',','.') }}
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>
                                <p>TOTAL $ </p>
                            </th>
                            <th class=" text-right">
                                <p id="suma"> {{ number_format($detallepresupuesto->sum('subtotal'),2,',','.') }} </p>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>

</script>
@stop