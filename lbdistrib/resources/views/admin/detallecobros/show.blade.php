@extends('base.base')

@section('title', 'Detalle cobro')

@section('breadcrumb')
    {!! Breadcrumbs::render('cobro.detalle', $cobro) !!}
@stop

@section('content')

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-lg-10">
                    <h5>
                        @if ($cobro->tipocomprobante == 9)
                            <span class="text-danger">
                                {{ ucwords(strtolower($cobro->Tipocomprobante->comprobante)) }}
                            </span>
                        @else
                            {{ ucwords(strtolower($cobro->Tipocomprobante->comprobante)) }}
                        @endif
                    </h5>
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    <a href="{{ route('print.comprobante', [$cobro->id, $cobro->tipocomprobante]) }}"
                        class="btn btn-success">
                        <i class="fa fa-print" aria-hidden="true"> </i>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-1 col-lg-1">
                    <a href="{{ route('contacto.show', [$cobro->contacto]) }}" class="btn btn-secondary">
                        Cerrar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="table-responsive">
                        <table class="table small table-borderless">
                            <tr>
                                <td style="width: 15%">Razón social</td>
                                <td>
                                    <b>
                                        {{ $cobro->Contacto->nombreempresa . ', ' . $cobro->Contacto->nombreCompleto() }}
                                    </b>
                                </td>
                                <td style="width: 15%">
                                    Fecha
                                </td>
                                <td>
                                    <b> {{ date('d-m-Y', strtotime($cobro->fecha)) }} </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Vendedor</td>
                                <td>
                                    @if ($cobro->vendedor)
                                        <b>{{ $cobro->Vendedor->nombrecompleto() }}</b>
                                    @endif

                                </td>
                                <td>Total</td>
                                <td><b> $ {{ $cobro->total }} </b></td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td><b> {{ $cobro->observaciones }} </b></td>
                                <td>Comprobante</td>
                                <td><b>{{ $cobro->Comprobante }}</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row bg-secondary text-white text-center mb-1">
                <div class="col">Nro cheque</div>
                <div class="col">Fecha de Cheque</div>
                <div class="col">Banco</div>
                <div class="col">Observaciones</div>
                <div class="col">Importe cheque</div>
                <div class="col"></div>
            </div>
            <div class="cheque">
                @include('admin.detallecobros.detallecheque')
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <p> Detalle de cada concepto </p>
                </div>
            </div>

            <div class="efectivo mt-1">
                @include('admin.detallecobros.detalleefectivo')
            </div>

        </div>
    </div>


@endsection


@section('js')

    <script>

    </script>
@stop
