@extends('base.base')

@section('title', 'Listar roles')

@section('breadcrumb')
    {!! Breadcrumbs::render('roles') !!}
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>
                        Roles
                        <small>
                            <a href="{{ route('roles.create') }}" class="btn btn-link">(+) Crear</a>
                        </small>
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <table class="table table-striped table-hover small" id="roles" style="font-size: smaller">
                        <thead>
                            <tr>
                                <td width="10px">Nro</td>
                                <td>Nombre</td>
                                <td>Slug</td>
                                <td>Special</td>
                                <td>Creacion</td>
                                <td>Actualizacion</td>
                                <td>Borrar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr id="fila{{ $role->id }}">
                                    <td>{{ $role->id }}</td>
                                    <td>
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-flat">
                                            {{ $role->name }}
                                        </a>
                                    </td>
                                    <td>{{ $role->slug }}</td>
                                    <td>{{ $role->special }}</td>
                                    <td>{{ date('d-m-Y', strtotime($role->created_at)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($role->updated_at)) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-link" id="eliminar" name="eliminar"
                                            value="{{ $role->id }}"
                                            onclick="return eliminarRegistro(this.value, '{{ route('roles.destroy') }}')">
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

    </script>

@endsection
