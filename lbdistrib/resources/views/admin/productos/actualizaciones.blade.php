@extends('base.base')

@section('title', 'Listado actualizaciones')

@section('breadcrumb')
    {!! Breadcrumbs::render('actualizacion') !!}
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    Actualizaciones
                    <small>
                        <a href="{{ route('producto.indice', 'todos') }}" class="btn btn-link">(+) Cargar actualización de
                            precios</a>
                    </small>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover small text-center" id="actualizaciones">
                        <thead>
                            <td>Nro</td>
                            <td>Fecha</td>
                            <td>Proveedor</td>
                            <td>Rubro</td>
                            <td>Marca</td>
                            <td>Bonificac</td>
                            <td>Flete</td>
                            <td>Margen</td>
                            <td>Reg modificados</td>
                            <td>Usuario</td>
                            <td width="15px"> </td>
                        </thead>
                        <tbody>
                            @foreach ($actualizaciones as $actualizacion)

                                <tr id="fila{{ $actualizacion->id }}">
                                    <td>{{ $actualizacion->id }}</td>
                                    <td>{{ date('d-m-Y', strtotime($actualizacion->created_at)) }}</td>
                                    <td>@if ($actualizacion->proveedor > 0){{ $actualizacion->Proveedor->nombreempresa }} @endif </td>
                                    <td>@if ($actualizacion->rubro > 0){{ $actualizacion->Rubro->nombre }} @endif </td>
                                    <td>@if ($actualizacion->marca > 0){{ $actualizacion->Marca->nombre }} @endif </td>
                                    <td>@if ($actualizacion->bonificacion > 0)<i class="text-danger"> {{ $actualizacion->bonificacion }} </i>@endif</td>
                                    <td>@if ($actualizacion->flete > 0)<i class="text-danger"> {{ $actualizacion->flete }} 	 </i>@endif</td>
                                    <td>@if ($actualizacion->margen > 0)<i class="text-danger"> {{ $actualizacion->margen }} </i> @endif</td>
                                    <td><i class="text-green"><b>{{ $actualizacion->registros }}</b></i></td>
                                    <td>{{ $actualizacion->Usuario->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-default btn-link" id="eliminar" name="eliminar"
                                            value="{{ $actualizacion->id }}"
                                            onclick="return eliminarRegistro(this.value, '{{ route('producto.destroyActualizacion') }}')">
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

@stop

@section('js')

    <script>
        $(function() {
            crearDataTable('actualizaciones', 1, 1);
        });
    </script>

@stop
