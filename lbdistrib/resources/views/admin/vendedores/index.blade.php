@extends('base.base')

@section('title', 'Listar vendedores')

@section('breadcrumb')
    {!! Breadcrumbs::render('inicio') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    Vendedores
                </div>

                <div class="card-body">
                    <div class="detalle">

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover small text-center" id="vendedores">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Nombre y Apellido</th>
                                        <th>Email</th>
                                        <th>Ver marcas asociadas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendedores as $vendedor)
                                        <tr id="fila{{ $vendedor->id }}">
                                            <td>{{ $vendedor->id }}</td>
                                            <td>{{ $vendedor->name }}</td>
                                            <td>{{ $vendedor->email }}</td>
                                            <td>
                                                <a href="{{ route('vendedor.asociar', $vendedor->id) }}">
                                                    Asociar marcas
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

@endsection
