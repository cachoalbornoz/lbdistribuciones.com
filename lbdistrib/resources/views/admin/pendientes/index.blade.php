@extends('base.base')

@section('title', 'Listado de Pendientes')

@section('breadcrumb')
    {!! Breadcrumbs::render('pendiente') !!}
@stop

@section('content')


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>Pendientes</h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <table class="table table-hover table-bordered small" id="pendientes" style="font-size: smaller">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <td class="text-center" width="15%">Razón social</td>
                                <td class="text-center" width="15px">Facturar</td>
                                <td class="text-center" width="20%">Producto</td>
                                <td class="text-center" width="15px">Cant</td>
                                <td class="text-center" width="15px">Precio</td>
                                <td class="text-center" width="15px">Desc</td>
                                <td class="text-center" width="15px">Fecha</td>
                                <td class="text-center" width="15px"> </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendientes as $pendiente)

                                <tr id="fila{{ $pendiente->id }}">
                                    <td>
                                        @if ($pendiente->Contacto)
                                            {{ $pendiente->Contacto->nombreempresa }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('presupuesto.editPendiente', $pendiente->id) }}">Facturar</a>
                                    </td>
                                    <td>
                                        @if ($pendiente->Producto)
                                            {{ $pendiente->Producto->nombre }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $pendiente->cantidad }} </td>
                                    <td class="text-center">{{ $pendiente->precio }} </td>
                                    <td class="text-center">{{ $pendiente->descuento }} </td>
                                    <td class="text-center">{{ date('d/m/Y', strtotime($pendiente->created_at)) }}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default btn-link" id="eliminar" name="eliminar"
                                            value="{{ $pendiente->id }}"
                                            onclick="return eliminarRegistro(this.value, '{{ route('pendiente.destroy') }}')">
                                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>
        $(function() {
            crearDataTable('pendientes', 1);
        });
    </script>

@stop
