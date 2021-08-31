@extends('errors.layout')

@section('title', 'Mensaje 503')


@section('content')


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <i class="fa fa-frown-o" aria-hidden="true"></i> - Estamos realizando mantenimiento al sitio
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <a href="{{ url('/')}}" class="btn btn-link">
                        <i class="fa fa-angle-double-left" aria-hidden="true"></i> volver
                    </a>
                </div>
            </div>
        </div>
    </div>


@endsection
