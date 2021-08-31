<div class="form-group">
    {{ Form::label('name', 'Nombre de la etiqueta') }}
    {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
</div>
<div class="form-group">
    {{ Form::label('slug', 'URL Amigable') }}
    {{ Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug']) }}
</div>
<div class="form-group">
    {{ Form::label('description', 'Descripción') }}
    {{ Form::text('description', null, ['class' => 'form-control']) }}
</div>
<hr>
<h5>Permisos especiales</h5>
<div class="form-group">
    <label>{{ Form::radio('special', 'all-access') }} Acceso total</label>
    <label>{{ Form::radio('special', 'no-access') }} Ningún acceso</label>
</div>
<hr>
<h5>Lista de permisos</h5>
<div class="form-group">

    <div class="table-responsive">
        <table class="table table-bordered small" id="permisos">
            <thead>
                <tr>
                    <td><input type="checkbox" /> Permiso</td>
                    <td>Ruta</td>
                    <td>Detalle del permiso</td>
                    <td>Creado</td>
                </tr>
            </thead>
            <tbody>

                @foreach ($permissions as $permission)
                    <tr id="fila{{ $permission->id }}">
                        <td>
                            <label>
                                {{ Form::checkbox('permissions[]', $permission->id, null) }}
                                {{ $permission->name }}
                            </label>
                        </td>
                        <td>
                            <em>{{ $permission->slug }}</em>
                        </td>
                        <td>
                            <em>{{ $permission->description }}</em>
                        </td>
                        <td>
                            {{ date('d-m-Y', strtotime($permission->created_at)) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-sm btn-primary']) }}
</div>
