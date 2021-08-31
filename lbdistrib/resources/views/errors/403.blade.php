@extends('errors.layout')

@section('title', 'Acceso denegado')


@section('content')


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <i class="fas fa-ban"></i> - Acceso denegado !
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <a href="{{ url('/home')}}" class="btn btn-link">
                        <i class="fa fa-angle-double-left" aria-hidden="true"></i> volver
                    </a>
                </div>
            </div>
        </div>
    </div>


@endsection
