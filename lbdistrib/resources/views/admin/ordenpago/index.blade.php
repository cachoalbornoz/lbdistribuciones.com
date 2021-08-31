@extends('base.base')

@section('title', 'Ordenes de Pago')

@section('breadcrumb')

    {!! Breadcrumbs::render('pago') !!}

@stop

@section('content')

    @if (isset($proveedor))
        @include('base.header-proveedor')
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <h5>
                        Orden de pago
                        @if (isset($id))
                            <a href="{{ route('ordenpago.create', $id) }}" class="btn btn-link">(+) Crear</a>
                        @else
                            <a href="{{ route('ordenpago.create', 0) }}" class="btn btn-link">(+) Crear</a>
                        @endif
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="detalle">
                        @include('admin.ordenpago.detalle')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    @if (!isset($proveedor))
        <script>
            crearDataTable('orden', 0, false);
        </script>
    @endif

    <script>
        const eliminarOrden = (id) => {
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
                        url: '{{ route('ordenpago.destroy') }}',
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
        };
    </script>

@stop
