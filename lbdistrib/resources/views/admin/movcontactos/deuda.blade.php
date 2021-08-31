@extends('base.base')

@section('title', 'Detalle deuda')

@section('breadcrumb')
    {!! Breadcrumbs::render('contacto.deuda', $contacto) !!}
@stop

@section('content')

    @if (isset($contacto))
        @include('base.header-cliente')
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
                    <div class="table-responsive">
                        <div id="detalle">
                            @include('admin.movcontactos.detalledeuda')
                        </div>
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
