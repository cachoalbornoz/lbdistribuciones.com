@extends('base.base')

@section('title', 'Movimientos proveedor')

@section('breadcrumb')
    {!! Breadcrumbs::render('proveedor.movproveedor', $proveedor) !!}
@stop

@section('content')

    @if (isset($proveedor))
        @include('base.header-proveedor')
    @endif


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <h5>Movimientos</h5>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 text-right">
                    <a href="{{ route('print.ctacte', [$proveedor->id, 2]) }}" class="btn btn-link">
                        Imprime movimientos <i class="fa fa-print text-success" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="detalle">
                        @include('admin.movproveedores.detalle')
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop

@section('js')

    <script>
        crearDataTable('movproveedores', 1, 1);


        const eliminarMovProveedor = (id) => {

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
                        url: '{{ route('movproveedor.destroy') }}',
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
                            $(document.body).css({
                                'cursor': 'default'
                            });
                        }
                    });
                }
            })
        }
    </script>

@stop
