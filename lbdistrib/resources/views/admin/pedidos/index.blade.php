@extends('base.base')

@section('title', 'Listado de Pedidos')

@section('breadcrumb')
    {!! Breadcrumbs::render('pedido') !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6 ">
                    <h5>
                        Nota pedido
                        <a href="{{ route('pedido.create') }}" class="btn btn-link"> (+) Crear </a>
                    </h5>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    @can('producto.destroy')
                        <a href="{{ route('pedido.facturado', 0) }}" class="btn btn-link"> Pedidos facturados </a>
                    </div>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table id="pedidos" class="table small table-hover table-bordered text-center" style="font-size: smaller">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <td width="15px">Editar</td>
                            <td>Fecha pedido</td>
                            <td>Razon social</td>
                            <td>Ver detalle</td>
                            <td>Productos pedidos</td>
                            <td>Facturar</td>
                            <td>Imprimir</td>
                            <td>Observaciones</td>
                            <td>Vendedor</td>
                            <td width="15px">Borrar</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos as $pedido)
                            <tr id="fila{{ $pedido->id }}">
                                <td>
                                    <a href="{{ route('pedido.edit', $pedido->id) }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td>{{ $pedido->fecha }}</td>
                                <td class=" text-left">

                                    @if (isset($pedido->contacto))
                                        {{ $pedido->Contacto->nombreempresa }}
                                    @else
                                        Info no disponible
                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('detallepedido.show', $pedido->id) }}">
                                        @if (isset($pedido->contacto))
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        @endif
                                    </a>
                                </td>
                                <td>{{ $pedido->productos->count() }}</td>
                                <td>
                                    @can('detallepedido.facturacion')
                                        <a href="{{ route('detallepedido.facturacion', $pedido->id) }}">
                                            Facturar
                                        </a>
                                    @endcan
                                </td>
                                <td>
                                    @can('detallepedido.facturacion')
                                        <a href="{{ route('print.pedido', [$pedido->id]) }}">
                                            <i class="fa fa-print" aria-hidden="true"> </i>
                                        </a>
                                    @endcan
                                </td>
                                <td class=" text-left">{{ $pedido->observaciones }}</td>
                                <td>{{ $pedido->Vendedor->nombreCompleto() }}</td>
                                <td>
                                    @can('pedido.destroy')
                                        <button type="button" class="btn btn-default btn-link" id="eliminar" name="eliminar"
                                            value="{{ $pedido->id }}"
                                            onclick="return eliminarRegistro(this.value, '{{ route('pedido.destroy') }}')">
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
        crearDataTable('pedidos', 1, 0);
    </script>

@stop
