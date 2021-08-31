@extends('base.base')

@section('title', 'Actualizacion productos')

@section('breadcrumb')
    {!! Breadcrumbs::render('actualizacion.parametro') !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>
                        Carga parámetros
                        <small>
                            <a href="{{ route('actualizacion.index') }}" class="btn btn-link"> Ver actualizaciones</a>
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
                <div class="col-xs-12 col-md-12 col-lg-12">
                    Grupos
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">

                    {!! Form::open(['id' => 'filtro', 'route' => 'actualizacion.buscar', 'method' => 'post', 'class' => 'form-ajax']) !!}

                    <table class="table table-hover small" style="font-size: smaller">
                        <tr>
                            <td width="35%"></td>
                            <td width="25%" colspan="2" class="text-center">Filtros</td>
                            <td width="40%" colspan="5" class="text-center">Nuevos valores </td>
                        </tr>
                        <tr>
                            <td width="35%">Producto a actualizar</td>
                            <td width="15%" class="text-center" style="border-color: green">Marca</td>
                            <td width="10%" class="text-center" style="border-color: green">Rubro</td>
                            <td width="8%" class="text-center" style="border-color: blue">P.Lista</td>
                            <td width="8%" class="text-center" style="border-color: blue">Bonific</td>
                            <td width="8%" class="text-center" style="border-color: blue">Flete</td>
                            <td width="8%" class="text-center" style="border-color: blue">Margen</td>
                            <td width="8%" class="text-center" style="border-color: blue"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{!! Form::select('marca', $marca, null, ['id' => 'marca', 'class' => 'select2 form-control', 'placeholder' => 'Marca']) !!}</td>
                            <td>{!! Form::select('rubro', $rubro, null, ['id' => 'rubro', 'class' => 'select2 form-control', 'placeholder' => 'Rubro']) !!}</td>
                            <td>{!! Form::number('preciolista', null, [
    'id' => 'preciolista',
    'class' => 'form-control
                            text-center',
    'min=0 max=2 step=0.01',
    'title' => 'Ingresar valores entre 0 y 2',
]) !!}</td>
                            <td>{!! Form::number('bonificacion', null, [
    'id' => 'bonificacion',
    'class' => 'form-control
                            text-center',
    'min=0 max=2 step=0.01',
]) !!}</td>
                            <td>{!! Form::number('flete', null, ['id' => 'flete', 'class' => 'form-control text-center', 'min=0 max=2 step=0.01']) !!}</td>
                            <td>{!! Form::number('margen', null, ['id' => 'margen', 'class' => 'form-control text-center', 'min=0 max=2 step=0.01']) !!}</td>
                            <td class="text-center">
                                <button type="button" id="aplicar" title="Aplicar actualización" class="btn btn-default"> <i
                                        class="fa fa-bolt text-danger" aria-hidden="true"></i> </button>
                            </td>
                        </tr>

                    </table>

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">

                    <div id="estado" class="d-none">
                        <p class="text-primary">
                            Esperando respuesta <img src="{{ asset('images/frontend/ocupado.gif') }}" alt="ocupado">
                        </p>
                    </div>

                    <div class="detalle">
                        @include('admin.actualizacion.detalleproducto')
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')

    <script>
        $('#aplicar').on('click', function() {

            if ($("#preciolista").val() == 0 && $("#bonificacion").val() == 0 && $("#flete").val() == 0 && $(
                    "#margen").val() == 0) {

                var texto = 'Al menos un valor debe ser mayor que 0';
                $("#marca").select();
                toastr.error(texto, 'PORCENTAJE DE ACTUALIZACION', {
                    closeButton: true
                });

            } else {

                $("#estado").removeClass('d-none');

                ymz.jq_confirm({
                    title: "&nbsp;",
                    text: "&nbsp; Actualiza los productos listados ? &nbsp;",
                    no_btn: "No",
                    yes_btn: "Si",
                    no_fn: function() {

                        $("#estado").addClass('d-none');

                        return false;
                    },
                    yes_fn: function() {

                        var form = $('#filtro');
                        var token = $('input[name=_token]').val();

                        var marca = $("#marca").val();
                        var rubro = $("#rubro").val();

                        var preciolista = $("#preciolista").val();
                        var bonificacion = $("#bonificacion").val();
                        var flete = $("#flete").val();
                        var margen = $("#margen").val();

                        $.ajax({

                            beforeSend: function() {
                                $('#estado').addClass('d-none');
                            },
                            url: '{{ route('actualizacion.actualizar') }}',
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                marca: marca,
                                rubro: rubro,
                                preciolista: preciolista,
                                bonificacion: bonificacion,
                                flete: flete,
                                margen: margen
                            },
                            success: function(response) {

                                $('.detalle').html(response);

                                $("#preciolista").val('');
                                $("#bonificacion").val('');
                                $("#flete").val('');
                                $("#margen").val('');
                                $("#marca").focus();
                                $('#estado').addClass('hidden');

                            }
                        });
                    }
                })
            }
        })


        $('#marca').on('change', function() {

            var form = $('#filtro');
            var token = $('input[name=_token]').val();

            $.ajax({
                beforeSend: function() {
                    $('#estado').removeClass('hidden');
                },
                url: $('.form-ajax').attr('action'),
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: form.serialize(),

                success: function(data) {
                    $('.detalle').html(data);
                    $('#estado').addClass('hidden');
                }
            });
        })

        $('#rubro').on('change', function() {

            var form = $('#filtro');
            var token = $('input[name=_token]').val();

            $.ajax({
                beforeSend: function() {
                    $('#estado').removeClass('hidden');
                },
                url: $('.form-ajax').attr('action'),
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'post',
                dataType: 'json',
                data: form.serialize(),

                success: function(data) {
                    $('.detalle').html(data);
                    $('#estado').addClass('hidden');
                }
            });
        })
    </script>

@stop
