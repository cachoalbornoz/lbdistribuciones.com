@extends('base.base')

@section('title', 'Listado de Pedidos')

@section('breadcrumb')
{!! Breadcrumbs::render('pedido') !!}
@stop

@section('content')


<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-6">
                <h5>Pedidos facturados</h5>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-6">
                <a href="{{ route('pedido.index') }}">
                    Nota Pedido
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="pedidosf" class="table table-bordered table-hover" style="font-size: smaller">
                <thead>
                    <tr>
                        <th width="15px">#</th>
                        <th width="15px">Nro</th>
                        <th class="text-center">Fecha facturación</th>
                        <th>Razón social</th>
                        <th class="text-center">Productos pedidos</th>
                        <th>Observaciones</th>
                        <th>Vendedor</th>
                        <th width="15px"> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)

                    <tr id="fila{{ $pedido->id }}">
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $pedido->id }}
                        </td>
                        <td>
                            {{ $pedido->updated_at }}
                        </td>
                        <td>
                            <a href="{{ route('detallepedido.show', $pedido->id) }}">
                                @if (isset($pedido->Contacto->nombreempresa))
                                {{ $pedido->Contacto->apellido }}, {{ $pedido->Contacto->nombres }}
                                @else
                                Info no disponible
                                @endif
                            </a>
                        </td>
                        <td>{{ $pedido->productos->count() }}</td>
                        <td>{{ $pedido->observaciones }}</td>
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
    $(document).ready(function(){

        var table = $('#pedidosf').DataTable({ 
            
            "lengthMenu"    : [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "order"         : [[ 2, "asc" ]],
            "stateSave"     : true,
            "columnDefs"    : [
                { orderable:    false   ,   targets: [0, 4, 5] },
                { className: 'text-center', targets: [0, 2, 4, 5] },
            ]            
        }); 
    });

</script>

@stop