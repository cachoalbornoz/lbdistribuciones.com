@extends('base.base')

@section('title', 'Listado contactos')

@section('breadcrumb')
    {!! Breadcrumbs::render('contacto') !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>
                        Clientes
                        @can('contacto.create')
                            <small>
                                <a href="{{ route('contacto.create') }}" class="btn btn-link">(+) Crear</a>
                            </small>
                        @endcan
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <table class="table table-bordered table-hover small text-center" id="contactos"
                        style="font-size: smaller">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <td style="width: 15%">Razon social</td>
                                <td style="width: 15%">Apellido</td>
                                <td style="width: 15%">Nombres</td>
                                <td style="width: 15%">Saldo$</td>
                                <td style="width: 15%">Ciudad</td>
                                <td style="width: 15%">Borrar </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contactos as $contacto)
                                <tr id="fila{{ $contacto->id }}">
                                    <td class=" text-left">
                                        <a href="{{ route('contacto.edit', $contacto->id) }}">
                                            {{ $contacto->nombreempresa }}
                                        </a>
                                    </td>
                                    <td class=" text-left">{{ $contacto->apellido }}</td>
                                    <td class=" text-left">{{ $contacto->nombres }}</td>
                                    <td>{{ number_format($contacto->saldo, 2, ',', '.') }}</td>
                                    <td>
                                        {{ $contacto->Ciudad->nombre }}
                                    </td>
                                    <td>
                                        @can('contacto.destroy')
                                            <button type="button" class="btn btn-flat" id="eliminar" name="eliminar"
                                                value="{{ $contacto->id }}"
                                                onclick="return eliminarRegistro(this.value, '{{ route('contacto.destroy') }}')">
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
    </div>

@stop

@section('js')

    <script>
        $(function() {
            crearDataTable('contactos', 0, false);
        })
    </script>

@stop
