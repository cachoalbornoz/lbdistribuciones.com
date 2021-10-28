@extends('base.base')

@section('title', 'Listado de Presupuestos')

@section('breadcrumb')
    {!! Breadcrumbs::render('presupuesto') !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>
                        Presupuesto
                        <a href="{{ route('presupuestop.create') }}" class="btn btn-link">
                            (+) Crear
                        </a>
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table small table-bordered table-hover" style="font-size: smaller" id="presupuestosp">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th class="text-center" width="15px">Editar</th>
                            <th>Razón social</th>
                            <th class="text-center">Productos presupuestados</th>
                            <th class="text-center">Importe total</th>
                            <th class="text-center">Imprime</th>
                            <th>Observaciones</th>
                            <th class="text-center">Modificación</th>
                            <th width="15px"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presupuestos as $presupuesto)

                            <tr id="fila{{ $presupuesto->id }}">
                                <td class="text-center">
                                    <a href="{{ route('presupuestop.edit', $presupuesto->id) }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('presupuestop.show', $presupuesto->id) }}">
                                        @if (isset($presupuesto->Proveedor->nombreempresa))
                                            {{ $presupuesto->Proveedor->nombreempresa }}
                                        @else
                                            Info no disponible
                                        @endif
                                    </a>
                                </td>
                                <td class="text-center">{{ $presupuesto->productos->count() }}</td>
                                <td class="text-center">
                                    {{ number_format($presupuesto->detallepresupuesto()->sum('subtotal'), 2, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('print.presupuestop', $presupuesto->id) }}">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                                <td>{{ $presupuesto->observaciones }}</td>
                                <td class="text-center">{{ date('d/m/Y H:i', strtotime($presupuesto->updated_at)) }}
                                </td>
                                <td>
                                    @can('presupuesto.destroy')
                                        <button type="button" class="btn btn-link" id="eliminar" name="eliminar"
                                            value="{{ $presupuesto->id }}"
                                            onclick="return eliminarRegistro(this.value, '{{ route('presupuestop.destroy') }}')">
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
        $(function() {

            crearDataTable('presupuestosp', 0, 0);
        })
    </script>

@stop
