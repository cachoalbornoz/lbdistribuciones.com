@extends('base.base')

@section('title', 'Listado proveedores')

@section('breadcrumb')
    {!! Breadcrumbs::render('proveedor') !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>
                        Proveedores
                        <small>
                            <a href="{{ route('proveedor.create') }}" class="btn btn-link">(+)
                                Crear
                            </a>
                        </small>
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center small" id="proveedores"
                    style="font-size: smaller">
                    <thead>
                        <tr class="bg-secondary text-white">
                            <td style="width: 15%">Razon social</td>
                            <td style="width: 15%">Apellido</td>
                            <td style="width: 15%">Nombres</td>
                            <td style="width: 15%">Saldo $</td>
                            <td style="width: 15%">Lista productos</td>
                            <td style="width: 15%">Ciudad</td>
                            <td style="width: 15%">Borrar </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $proveedor)
                            <tr id="fila{{ $proveedor->id }}">
                                <td class="text-left">
                                    <a href="{{ route('proveedor.edit', $proveedor->id) }}">
                                        {{ $proveedor->nombreempresa }}
                                    </a>
                                </td>
                                <td class="text-left">{{ $proveedor->apellido }}</td>
                                <td class="text-left">{{ $proveedor->nombres }}</td>
                                <td class=" text-center">{{ number_format($proveedor->saldo, 2, ',', '.') }}</td>
                                <td class=" text-center">
                                    <a href="{{ route('print.productoproveedor', $proveedor->id) }}">
                                        <i class="fa fa-barcode text-success" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td>{{ $proveedor->Ciudad->nombre }}</td>
                                <td>
                                    <button type="button" class="btn btn-default btn-link" id="eliminar" name="eliminar"
                                        value="{{ $proveedor->id }}"
                                        onclick="return eliminarRegistro(this.value, '{{ route('proveedor.destroy') }}')">
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

@stop

@section('js')

    <script>
        $(function() {
            crearDataTable('proveedores', 1, false);
        });
    </script>

@stop
