@extends('errors.layout')

@section('title', 'Rutina inesperada')


@section('content')


<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <i class="fa fa-frown-o"></i> - Rutina inesperada
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12 text-center">
                <img src="{{ asset('images/frontend/fardos.png')}}" alt="Upss">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12 text-right">
                <a href="{{ route('home') }}" class="btn btn-info">
                    <i class="fa fa-angle-double-left" aria-hidden="true"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>


@endsection