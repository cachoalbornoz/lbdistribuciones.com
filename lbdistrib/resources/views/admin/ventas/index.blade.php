@extends('base.base')

@section('title', 'Listado de ventas')

@section('breadcrumb')

    @if (isset($contacto))
        {!! Breadcrumbs::render('venta.contacto', $contacto) !!}
    @else
        {!! Breadcrumbs::render('venta') !!}
    @endif

@endsection

@section('content')

    @if (isset($contacto))
        @include('base.header-cliente')
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <h5>Ventas
                        @can('venta.create')
                            @if (isset($id))
                                <a href="{{ route('venta.create', $id) }}" class="btn btn-link">(+) Crear</a>
                            @else
                                <a href="{{ route('venta.create', null) }}" class="btn btn-link">(+) Crear</a>
                                &nbsp;
                                <a href="{{ route('producto.estadisticas') }}" class="btn btn-link"
                                    title="Estadistica de ventas">
                                    Estadisticas
                                </a>
                            @endif
                        @endcan
                    </h5>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                    {{ Form::open(['route' => 'venta.buscar', 'class' => 'form-ajax form-inline']) }}

                    <div class="form-group">
                        <button type="button" class="btn btn-primary">
                            Filtrar
                        </button>
                    </div>
                    <div class="form-group">
                        @if (isset($vendedor))
                            {!! Form::select('vendedor', $vendedor, null, ['id' => 'vendedor', 'class' => 'select btn btn-default', 'placeholder' => 'Vendedor ...']) !!}
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::date('desde', \Carbon\Carbon::now()->subMonth(), ['id' => 'desde', 'class' => 'form-control text-center', 'placeholder' => 'fecha desde']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::date('hasta', \Carbon\Carbon::now(), ['id' => 'hasta', 'class' => 'form-control text-center', 'placeholder' => 'fecha hasta']) !!}
                    </div>
                    <div class="form-group">
                        <button type="button" id="filtro" class="btn btn-info" title="Aplicar filtro">
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>
                    <div class="form-group">
                        <button type="button" id="quitar" class="btn btn-primary" title="Quitar filtro">
                            X
                        </button>
                    </div>

                    @if (isset($contacto))
                        <input type="hidden" id="contacto" name="contacto" value="{{ $contacto->id }}">
                    @else
                        <input type="hidden" id="contacto" name="contacto" value="">
                    @endif

                    {{ Form::close() }}

                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="detalle">
                        @include('admin.ventas.detalle')
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('js')

    @if (!isset($contacto))
        <script>
            crearDataTable('ventas', 0, false);
        </script>
    @endif

    <script>
        const eliminarVenta = (id) => {
            ymz.jq_confirm({
                title: "Eliminar",
                text: '<div class=" text-center">Confirma ? </div>',
                no_btn: "No",
                yes_btn: "Si",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {
                    var token = $('input[name=_token]').val();
                    $.ajax({
                        url: '{{ route('venta.destroy') }}',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id,
                        },
                        success: function(data) {
                            $(".detalle").html(data);
                        }
                    });
                }
            })
        }


        $('#filtro').on('click', function() {

            var token = $('input[name=_token]').val();

            $.ajax({
                url: $('.form-ajax').attr('action'),
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    contacto: $("#contacto").val(),
                    vendedor: $("#vendedor").val(),
                    desde: $("#desde").val(),
                    hasta: $("#hasta").val()
                },

                success: function(data) {
                    $('#detalle').html(data);
                }
            });

            return false;
        })

        $('#quitar').on('click', function() {

            var token = $('input[name=_token]').val();

            $.ajax({
                url: $('.form-ajax').attr('action'),
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    contacto: $("#contacto").val(),
                    quitar: true
                },

                success: function(data) {

                    $('#detalle').html(data);
                    $('#desde').val('');
                    $('#hasta').val('');
                    $("#vendedor").val('')
                }
            });

            return false;
        })
    </script>

@stop
