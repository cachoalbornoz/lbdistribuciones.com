@extends('base.base')

@section('title', 'Listado productos')

@section('breadcrumb')
    {!! Breadcrumbs::render('producto') !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-lg-8">
                    <h5>Impresión de Productos </h5>
                </div>
                <div class="col-xs-12 col-sm-4 col-lg-4 text-center">
                    <a href="{{ route('print.productolistado') }}" class="btn btn-link">
                        Listado completa de productos
                    </a>
                </div>
            </div>
        </div>

        <div class="card-group">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-5 text-center">
                        <div class="col-4">
                            {!! Form::select('marcas[]', $marca, null, ['class' => 'js-example-basic-multiple form-control marcas0', 'multiple' => 'multiple']) !!}
                            <small>Marcas</small>
                        </div>
                        <div class="col-4">
                            {!! Form::select('rubros[]', $rubro, null, ['class' => 'js-example-basic-multiple form-control rubros0', 'multiple' => 'multiple']) !!}
                            <small>Rubros</small>
                        </div>
                        <div class="col-4">
                            <a href="#" id="printMarcaRubro">Marca y Rubro</a>
                        </div>
                    </div>
                    <div class="row mb-5 text-center">
                        <div class="col-8">
                            {!! Form::select('marcas[]', $marca, null, ['class' => 'js-example-basic-multiple form-control marcas', 'multiple' => 'multiple']) !!}
                            <small>Marcas</small>
                        </div>
                        <div class="col-4">
                            <a href="#" id="printMarca">Marca</a>
                        </div>
                    </div>
                    <div class="row mb-5 text-center">
                        <div class="col-8">
                            {!! Form::select('rubros[]', $rubro, null, ['class' => 'js-example-basic-multiple form-control rubros', 'multiple' => 'multiple']) !!}
                            <small>Rubros</small>
                        </div>
                        <div class="col-4">
                            <a href="#" id="printRubro">Rubro</a>
                        </div>
                    </div>
                </div>
            </div>

        @stop

        @section('js')

            <script>
                $(document).ready(function() {
                    $('.js-example-basic-multiple').select2({
                        placeholder: " Seleccione item o varios ",
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

                $(document).on('click', '#printMarcaRubro', function() {
                    var idRubros = [];
                    $('.rubros0 :selected').each(function() {
                        idRubros.push($(this).val());
                    });

                    var idMarcas = [];
                    $('.marcas0 :selected').each(function() {
                        idMarcas.push($(this).val());
                    });

                    // Si NO eligió ninguno
                    if (idRubros.length == 0 && idMarcas.length == 0) {
                        toastr.options = {
                            "progressBar": true,
                            "showDuration": "500",
                            "timeOut": "2000"
                        };
                        toastr.warning("&nbsp;", "Seleccione al menos un rubro o marca");
                        return;
                    }

                    // Si eligio ambos
                    if (idRubros.length > 0 && idMarcas.length > 0) {
                        url = '{{ route('print.productorubromarca', [':rubros', ':marcas']) }}';
                        url = url.replace(':rubros', idRubros);
                        url = url.replace(':marcas', idMarcas);
                    } else {
                        // Si sólo eligió Rubros
                        if (idRubros.length > 0 && idMarcas.length == 0) {
                            url = '{{ route('print.productorubros', ':id') }}';
                            url = url.replace(':id', idRubros);
                        }
                        // Si sólo eligió Marcas
                        if (idRubros.length == 0 && idMarcas.length > 0) {
                            url = '{{ route('print.productomarcas', ':id') }}';
                            url = url.replace(':id', idMarcas);
                        }
                    }

                    var a = document.createElement('a');
                    a.target = "_blank";
                    a.href = url;
                    a.click();
                })
            </script>
        @stop
