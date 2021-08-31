@extends('base.base')

@section('title', 'Reset password')

@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        Resetear clave
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row mb-5">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        @if(Session::has('message'))
                            <div class="alert {{ Session::get('alert-class') }} alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {{Session::get('message')}}
                            </div>
                        @endif
                    </div>
                </div>

                <form method="POST" action="{{ route('reset-password') }}">
                @csrf

                <input type="hidden" name="token" id="token" value="{{ $token }}">

                <div class="row mb-5 justify-content-center  ">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label>Email</label>
                        <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus >
                    </div>
                </div>

                <div class="row mb-5 justify-content-center  ">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label>Nueva clave</label>
                        <input id="password" type="password" class="form-control" name="password">
                        <small>Mínimo 8 caracteres</small>
                    </div>
                </div>

                <div class="row mb-5 justify-content-center  ">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <label>Confirme nueva clave</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>

                <div class="row mb-5 justify-content-center ">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
@endsection
