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
                    @include('admin.movproveedores.detalle')
                </div>
            </div>
        </div>

    </div>

@stop

@section('js')

    <script>
        $(function() {
            crearDataTable('movproveedores', 1, 1);
        });
    </script>

@stop
