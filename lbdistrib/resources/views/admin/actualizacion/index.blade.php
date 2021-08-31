@extends('base.base')

@section('title', 'Listado actualizaciones')

@section('breadcrumb')
    {!! Breadcrumbs::render('actualizacion') !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>
                        Actualizaciones
                        <small>
                            <a href="{{ route('actualizacion.parametro') }}" class="btn btn-link">(+) Cargar actualización
                                de precios</a>

                            @can('dolar.edit')

                                | &nbsp;

                                <a href="{{ route('dolar.edit', 1) }}" class="btn btn-link"> u$s Cotización Dolar </a>

                            @endcan
                        </small>
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover small" id="actualizacion" style="font-size: smaller">
                            <thead>
                                <td width="15px">#Nro</td>
                                <td class="text-center">Marca</td>
                                <td class="text-center">Rubro</td>
                                <td class="text-center">P.Lista</td>
                                <td class="text-center">Bonif</td>
                                <td class="text-center">Flete</td>
                                <td class="text-center">Margen</td>
                                <td class="text-center">Reg</td>
                                <td class="text-center">Reversar</td>
                                <td class="text-center">Usuario</td>
                                <td class="text-center">Fecha</td>
                                <td width="15px">Borrar </td>
                            </thead>
                            <tbody>
                                @foreach ($actualizaciones as $actualizacion)

                                    <tr id="fila{{ $actualizacion->id }}">
                                        <td>{{ $actualizacion->id }}</td>
                                        <td>@if ($actualizacion->marca > 0){{ $actualizacion->Marca->nombre }} @endif </td>
                                        <td>@if ($actualizacion->rubro > 0){{ $actualizacion->Rubro->nombre }} @endif </td>
                                        <td class="text-center">@if ($actualizacion->preciolista > 0)<i class="text-bold"> {{ $actualizacion->preciolista }} </i>@endif</td>
                                        <td class="text-center">@if ($actualizacion->bonificacion > 0)<i class="text-bold"> {{ $actualizacion->bonificacion }} </i>@endif</td>
                                        <td class="text-center">@if ($actualizacion->flete > 0)<i class="text-bold"> {{ $actualizacion->flete }} </i>@endif</td>
                                        <td class="text-center">@if ($actualizacion->margen > 0)<i class="text-bold"> {{ $actualizacion->margen }} </i> @endif</td>
                                        <td class="text-center">{{ $actualizacion->registros }}</td>
                                        <td class="text-center">
                                            @if (!$actualizacion->reversa)
                                                <a href="{{ route('actualizacion.reversar', $actualizacion->id) }}"
                                                    class="btn btn-link"
                                                    title="Anula la actualización aplicada a los {{ $actualizacion->registros }} registros">
                                                    <i class="fa fa-backward text-black-50" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $actualizacion->Usuario->name }}</td>
                                        <td class="text-center">{{ $actualizacion->created_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-link" id="eliminar"
                                                name="eliminar" value="{{ $actualizacion->id }}"
                                                onclick="return eliminarRegistro(this.value, '{{ route('actualizacion.destroy') }}')">
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

@stop

@section('js')

    <script>
        $(function() {
            crearDataTable('actualizacion', 1);
        });
    </script>

@stop
