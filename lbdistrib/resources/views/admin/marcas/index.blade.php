@extends('base.base')

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('/css/jquery.fancybox.min.css') }}">
@endsection

@section('breadcrumb')
    {!! Breadcrumbs::render('marca') !!}
@stop

@section('title', 'Listado marcas')

@section('content')


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>
                        Marcas
                        <small>
                            <a href="{{ route('marca.create') }}" class="btn btn-link">(+) Crear</a>

                            <a href="javascript:void(0)" id="imprimir" name="imprimir" class="btn btn-link">
                                Imprimir lista precio
                            </a>
                        </small>
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover small text-center" id="marcas"
                            style="font-size: smaller">
                            <thead>
                                <tr>
                                    <td>Nro</td>
                                    <td>Nombre marca</td>
                                    <td><i class="fa fa-print text-success" aria-hidden="true"></i></td>
                                    <td>Imagen</td>
                                    <td width="15px"> </td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($marcas as $marca)

                                    <tr id="fila{{ $marca->id }}">
                                        <td>
                                            {{ $marca->id }}
                                        </td>
                                        <td>
                                            <a href="{{ route('marca.edit', $marca->id) }}">
                                                {{ strtoupper($marca->nombre) }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="imprimirMarca" value="{{ $marca->id }}">
                                        </td>
                                        <td>
                                            @if (isset($marca->image))
                                                <a href="{{ asset('images/upload/marcas/' . $marca->image) }}"
                                                    data-fancybox="gallery" data-caption="{{ $marca->nombre }}">
                                                    <img src="{{ asset('images/upload/marcas/' . $marca->image) }}"
                                                        class="img-rounded" height="35px" width="35px">
                                                </a>
                                            @else
                                                <img src="{{ asset('images/frontend/imagen-no-disponible.png') }}"
                                                    class="img-rounded" height="35px" width="35px">
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-default btn-link" id="eliminar"
                                                name="eliminar" value="{{ $marca->id }}"
                                                onclick="return eliminarRegistro(this.value, '{{ route('marca.destroy') }}')">
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

    <script src="{{ asset('/js/jquery.fancybox.min.js') }}"> </script>

    <script>
        $(document).on('click', '#imprimir', function() {

            var id = [];

            $('.imprimirMarca:checked').each(function() {

                id.push($(this).val());
            })

            if (id.length > 0) {

                url = '{{ route('print.productomarcas', ':id') }}';
                url = url.replace(':id', id);

                var a = document.createElement('a');
                a.target = "_blank";
                a.href = url;
                a.click();

            } else {

                toastr.options = {
                    "progressBar": true,
                    "showDuration": "500",
                    "timeOut": "2000"
                };
                toastr.warning("&nbsp;", "Seleccione al menos una marca");

            }

        })

        $(function() {
            crearDataTable('marcas', 1, false);
        });
    </script>

@stop
