@extends('base.base')

@section('breadcrumb')
    {!! Breadcrumbs::render('rubro') !!}
@stop

@section('title', 'Listado rubros')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    Rubros <small><a href="#" class="add-modal btn btn-link">(+) Crear</a></small>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    {{ csrf_field() }}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover small text-center" id="rubros"
                            style="font-size: smaller">
                            <thead>
                                <tr>
                                    <td>Nro </td>
                                    <td>Nombre</td>
                                    <td>Editar</td>
                                    <td>Borrar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rubros as $rubro)
                                    <tr class="item{{ $rubro->id }}">
                                        <td>{{ $rubro->id }}</td>
                                        <td>{{ $rubro->nombre }}</td>
                                        <td>
                                            <button class="edit-modal btn btn-default btn-link"
                                                data-id="{{ $rubro->id }}" data-nombre="{{ $rubro->nombre }}">
                                                <i class="fa fa-pencil text-success" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="delete-modal btn btn-default btn-link"
                                                data-id="{{ $rubro->id }}" data-nombre="{{ $rubro->nombre }}">
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
    </div>

    <!-- Modal form to delete -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-group">
                        <p class="text-center">Seguro que desea borrar?</p>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">Id:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nombre">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nombre" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                            <span id="" class='fa fa-trash-o'></span> Borrar
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to add -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title"></p>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nombre_add">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nombre_add" name="nombre_add" autofocus>

                                <small>Min: 2, Max: 32, solo texto</small>
                                <p class="errorNombre text-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success add" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Agregar
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to edit -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title"></p>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id_edit">Id:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_edit" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nombre_edit">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nombre_edit" autofocus>

                                <small>Min: 2, Max: 32, solo texto</small>
                                <p class="errorNombre text-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success edit" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-pencil'></span> Modificar
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')

    <script>
        $(document).on('click', '.add-modal', function() {
            $('.modal-title').text('Agregar rubro');
            $('#addModal').modal('show');
        });

        $('.modal-footer').on('click', '.add', function() {

            $.ajax({
                type: 'POST',
                url: '{{ route('rubro.store') }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nombre': $('#nombre_add').val(),
                },
                success: function(data) {

                    $('.errorNombre').addClass('hidden');

                    if ((data.errors)) {

                        setTimeout(function() {
                            $('#addModal').modal('show');
                        }, 500);



                        if (data.errors.nombre) {
                            $('.errorNombre').removeClass('hidden');
                            $('.errorNombre').text(data.errors.nombre);
                        }

                    } else {

                        toastr.success('Agregado !', {
                            timeOut: 5000
                        });
                        $('#rubros').append('<tr class="item' + data.id + '"><td>' + data.id +
                            '</td><td>' + data.nombre +
                            '</td><td><button class="edit-modal btn-link" data-id="' + data.id +
                            '" data-content="' + data.nombre +
                            '"><i class="fa fa-pencil text-success" aria-hidden="true"></i></button></td><td><button class="delete-modal btn-link" data-id="' +
                            data.id + '" data-nombre="' + data.nombre +
                            '"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></button></td></tr>'
                            );
                    }
                }
            });
        });


        $(document).on('click', '.edit-modal', function() {
            $('.modal-title').text('Modificar rubro');
            $('#id_edit').val($(this).data('id'));
            $('#nombre_edit').val($(this).data('nombre'));
            $('#editModal').modal('show');
        });

        $('.modal-footer').on('click', '.edit', function() {

            $.ajax({
                type: 'POST',
                url: '{{ route('rubro.update') }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('#id_edit').val(),
                    'nombre': $('#nombre_edit').val(),
                },
                success: function(data) {

                    $('.errorNombre').addClass('hidden');

                    if ((data.errors)) {

                        setTimeout(function() {
                            $('#editModal').modal('show');
                        }, 500);

                        if (data.errors.nombre) {
                            $('.errorNombre').removeClass('hidden');
                            $('.errorNombre').text(data.errors.nombre);
                        }

                    } else {

                        toastr.success('Modificado !', {
                            timeOut: 5000
                        });
                        $('.item' + data.id).replaceWith('<tr class="item' + data.id + '"><td>' + data
                            .id + '</td><td>' + data.nombre +
                            '</td><td><button class="edit-modal btn-link" data-id="' + data.id +
                            '" data-content="' + data.nombre +
                            '"><i class="fa fa-pencil text-success" aria-hidden="true"></i></button></td><td><button class="delete-modal btn-link" data-id="' +
                            data.id + '" data-nombre="' + data.nombre +
                            '"><i class="fa fa-trash-o text-danger" aria-hidden="true"></i></button></td></tr>'
                            );
                    }
                }
            });
        });

        $(document).on('click', '.delete-modal', function() {
            $('.modal-title').text('Borrar');
            $('#id').val($(this).data('id'));
            $('#nombre').val($(this).data('nombre'));
            $('#deleteModal').modal('show');

            id = $('#id').val();
        });
        $('.modal-footer').on('click', '.delete', function() {

            $.ajax({
                type: 'DELETE',
                url: '{{ route('rubro.destroy') }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: id
                },
                success: function(data) {

                    toastr.success('Borrado !', 'Success Alert', {
                        timeOut: 5000
                    });

                    $('.item' + data['id']).remove();
                }
            });
        });

        $(function() {
            crearDataTable('rubros', 1, false);
        });
    </script>

@stop
