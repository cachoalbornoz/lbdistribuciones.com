@extends('base.base')

@section('title', 'Movimientos contacto')

@section('breadcrumb')
    {!! Breadcrumbs::render('contacto.movcontacto', $contacto) !!}
@stop

@section('content')

    @if (isset($contacto))
        @include('base.header-cliente')
    @endif


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <h5>Movimientos</h5>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    {{ Form::open(['route' => 'movcontacto.buscar', 'class' => 'form-ajax form-inline']) }}

                    <div class="form-group">
                        <button type="button" class="btn btn-primary">
                            Filtrar
                        </button>
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
                    <div class="form-group">
                        <button type="button" id="print" class="btn btn-primary" title="Imprimir datos filtrados">
                            <i class="fa fa-print"></i>
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
                    <div id="detalle">
                        @include('admin.movcontactos.detalle')
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@section('js')

    <script>
        crearDataTable('movcontactos', 0, 1);

        const eliminarMovContacto = (id) => {

            ymz.jq_confirm({
                title: "Eliminar",
                text: '<div class=" text-center">Confirma ? </div>',
                no_btn: "No",
                yes_btn: "Si",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {
                    $(document.body).css({
                        'cursor': 'wait'
                    });
                    var token = $('input[name=_token]').val();
                    $.ajax({
                        url: '{{ route('movcontacto.destroy') }}',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id,
                        },
                        success: function(data) {
                            $("#detalle").html(data);
                            $(document.body).css({
                                'cursor': 'default'
                            });
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
                    desde: $("#desde").val(),
                    hasta: $("#hasta").val()
                },

                success: function(data) {
                    $('#detalle').html(data);
                }
            });

            return false;
        })



        $('#print').on('click', function() {

            var base = '{{ url('/') }}';
            var id = {{ $contacto->id }};
            var fechad = $('#desde').val();
            var fechah = $('#hasta').val();
            window.location = base + "/print/" + id + "/printCtaCteFecha/" + "1/" + fechad + "/" + fechah;

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
                }
            });

            return false;
        })
    </script>

@stop
