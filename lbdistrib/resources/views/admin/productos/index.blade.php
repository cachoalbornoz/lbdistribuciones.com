@extends('base.base')

@section('title', 'Listado productos')

@section('breadcrumb')
    {!! Breadcrumbs::render('producto') !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <h5>Productos
                        <small>
                            @can('producto.destroy')
                                <a href="{{ route('producto.create') }}" class="btn btn-link">(+) Crear</a>
                                &nbsp;| &nbsp;
                                <a href="{{ route('producto.estadisticas') }}" class="btn btn-link"
                                    title="Estadistica de ventas">
                                    Estadisticas
                                    &nbsp;| &nbsp;
                                    <a href="{{ route('print.productoForm') }}" class="btn btn-link">
                                        Opciones de Impresión
                                    </a>
                                    &nbsp;| &nbsp;
                                    <a href="{{ route('producto.excel') }}" class="btn btn-link">
                                        Exportar Excel
                                    </a>
                                    &nbsp;| &nbsp;
                                    <a href="{{ route('actualizacion.parametro') }}" class="btn btn-link">
                                        Actualizaciones
                                    </a>
                                </a>
                            @endcan
                        </small>
                    </h5>

                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="producto">
                <table class="table table-bordered table-hover table-condensed small" style="font-size: smaller"
                    id="productos">
                    <thead>
                        <tr>
                            <td>Editar</td>
                            <td>Codigo</td>
                            <td>Nombre del producto</td>
                            <td style=" width: 10px">Stock</td>
                            <td style=" width: 10px">PrecioVenta</td>
                            <td style=" width: 200px">Marca</td>
                            <td style=" width: 200px">Rubro</td>
                            <td style=" width: 10px">Borrar</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

@section('js')

    <script>
        var table = $('#productos').DataTable({
            scrollCollapse: true, //Esto sirve que se auto ajuste la tabla al aplicar un filtro
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"]
            ],
            order: [
                [0, "asc"]
            ],
            stateSave: true,
            processing: true,
            serverSide: true,
            language: {
                "url": "{{ url('public/DataTables/spanish.json') }}"
            },
            ajax: "{{ route('producto.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    class: "text-center"
                },
                {
                    data: 'codigobarra',
                    name: 'codigobarra',
                    orderable: true,
                    searchable: true,
                    class: "text-center"
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'stockactual',
                    name: 'stockactual',
                    orderable: true,
                    searchable: false,
                    class: "text-center"
                },
                {
                    data: 'precioventa',
                    name: 'precioventa',
                    orderable: true,
                    searchable: false,
                    class: "text-center"
                },
                {
                    data: 'marca',
                    name: 'marca',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'rubro',
                    name: 'rubro',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'borrar',
                    name: 'borrar',
                    orderable: false,
                    searchable: false,
                    class: "text-center"
                },
            ]
        });

        $('#productos').on("click", ".borrar", function() {


            var texto = '&nbsp; Elimina producto? &nbsp;';
            var id = this.id;

            ymz.jq_confirm({
                title: texto,
                text: "",
                no_btn: "Cancelar",
                yes_btn: "Confirma",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {

                    var token = $('input[name=_token]').val();

                    $.ajax({

                        url: "{{ route('producto.destroy') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            table.ajax.reload();
                            toastr.options = {
                                "progressBar": true,
                                "showDuration": "300",
                                "timeOut": "1000"
                            };
                            toastr.error("&nbsp;", "Producto eliminado ... ");
                        }
                    });
                }
            });
        });
    </script>

@stop
