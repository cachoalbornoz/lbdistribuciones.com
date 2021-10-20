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
                    <h5>Impresión de Productos </h5>
                </div>
            </div>
        </div>

        <div class="card-group">

            <div class="card">
                <div class="card-body">
                    <a href="{{ route('print.productolistado') }}" class="btn btn-link">
                        Imprime listado de productos
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    {!! Form::select('marcas[]', $marca, null, ['class' => 'js-example-basic-multiple form-control marcas', 'multiple' => 'multiple']) !!}
                    <button class=" btn btn-outline-primary mt-3" id="printMarca">Marca</button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    {!! Form::select('rubros[]', $rubro, null, ['class' => 'js-example-basic-multiple form-control rubros', 'multiple' => 'multiple']) !!}
                    <button class=" btn btn-outline-primary mt-3" id="printRubro">Rubro</button>
                </div>
            </div>



        </div>
    </div>

@stop

@section('js')

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: " Un item o varios a imprimir ",
                allowClear: true
            });
        });

        $(document).on('click', '#printMarca', function() {
            var id = [];
            $('.marcas :selected').each(function() {
                id.push($(this).val());
            });

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

        $(document).on('click', '#printRubro', function() {
            var id = [];
            $('.rubros :selected').each(function() {
                id.push($(this).val());
            });

            if (id.length > 0) {
                url = '{{ route('print.productorubros', ':id') }}';
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
                toastr.warning("&nbsp;", "Seleccione al menos un rubro");
            }
        })
    </script>
@stop
