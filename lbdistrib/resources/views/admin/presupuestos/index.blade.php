@extends('base.base')

@section('title', 'Listado de Presupuestos')

@section('breadcrumb')
    {!! Breadcrumbs::render('presupuesto') !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <h5>
                        Presupuesto
                        <a href="{{ route('presupuesto.create') }}" class="btn btn-link">
                            (+) Crear
                        </a>

                    </h5>
                </div>
                <div class="col-xs-6 text-right">
                    <a href="{{ route('presupuesto.facturado', 0) }}" class="btn btn-link">
                        Presupuestos facturados
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table small table-hover table-bordered text-center" style="font-size: smaller"
                    id="presupuestos">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <td width="15px">Editar</td>
                            <td>Fecha pedido</td>
                            <td>Razón social</td>
                            <td></td>
                            <td>CantProdPresup.</td>
                            <td>Importe total</td>
                            <td>Imprime</td>
                            <td>Observaciones</td>
                            <td>Vendedor</td>
                            <td>Modificación</td>
                            <td width="15px"> </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presupuestos as $presupuesto)

                            <tr id="fila{{ $presupuesto->id }}">
                                <td>
                                    <a href="{{ route('presupuesto.edit', $presupuesto->id) }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td>{{ $presupuesto->fecha }}</td>
                                <td class=" text-left">
                                    <a href="{{ route('presupuesto.show', $presupuesto->id) }}">
                                        @if (isset($presupuesto->Contacto->nombreempresa))
                                            {{ $presupuesto->Contacto->nombreempresa }}
                                        @else
                                            Info no disponible
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    @if (is_null($presupuesto->estado))
                                        @can('presupuesto.facturado')
                                            <a href="{{ route('detallepresupuesto.facturacion', $presupuesto->id) }}">
                                                Facturar
                                            </a>
                                        @endcan
                                    @endif
                                </td>
                                <td>{{ $presupuesto->productos->count() }}</td>
                                <td>{{ $presupuesto->detallepresupuesto()->sum('subtotal') }}</td>
                                <td>
                                    <a href="{{ route('print.presupuesto', $presupuesto->id) }}">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                                <td class=" text-left">{{ $presupuesto->observaciones }}</td>
                                <td class=" text-left">{{ $presupuesto->Vendedor->nombreCompleto() }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($presupuesto->updated_at)) }}
                                </td>
                                <td>
                                    @can('presupuesto.destroy')
                                        <button type="button" class="btn btn-default btn-link" id="eliminar" name="eliminar"
                                            value="{{ $presupuesto->id }}"
                                            onclick="return eliminarRegistro(this.value, '{{ route('presupuesto.destroy') }}')">
                                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>
        crearDataTable('presupuestos', 0, 0);
    </script>

@stop
