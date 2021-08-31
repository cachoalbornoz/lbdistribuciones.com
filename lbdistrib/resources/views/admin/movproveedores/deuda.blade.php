@extends('base.base')

@section('title', 'Detalle deuda')

@section('breadcrumb')
    {!! Breadcrumbs::render('proveedor.deuda', $proveedor) !!}
@stop

@section('content')

    @if (isset($proveedor))
        @include('base.header-proveedor')
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <h5>Detalle de Deuda</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div id="detalle">
                        @include('admin.movproveedores.detalledeuda')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

    <script>



    </script>

@stop
