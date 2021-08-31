<div class="table-responsive">
    <table class="table table-bordered table-hover small text-center" id="users">
        <thead>
            <tr>
                <td>Nro</td>
                <td>Nombre usuario</td>
                <td>Mail</td>
                <td>Foto</td>
                <td>Role</td>
                <td width="15px"> </td>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)

                <tr id="fila{{ $user->id }}">
                    <td>{{ $user->id }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-flat">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td> <img src="{{ asset('images/upload/usuarios/' . $user->image) }}" class="img-rounded"
                            height="50"> </td>
                    <td> {{ $user->roles->first()->name }} </td>
                    <td>
                        <button type="button" class="btn btn-default btn-link" id="eliminar" name="eliminar"
                            value="{{ $user->id }}"
                            onclick="return eliminarRegistro(this.value, '{{ route('users.destroy') }}')">
                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>
</div>
