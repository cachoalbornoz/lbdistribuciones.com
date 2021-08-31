@extends('base.base')

@section('title', 'Resetear password')

<!-- Main Content -->
@section('content')

<div class="container">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            &nbsp;
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    Resetear contraseña
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-6 col-lg-6 mb-5">
                    @if(Session::has('message'))
                        <div class="alert {{ Session::get('alert-class') }} alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{Session::get('message')}}
                        </div>
                    @endif

                </div>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ route('password-reset') }}" autocomplete="off">
                {{ csrf_field() }}

                <div class="row justify-content-center mb-5">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label>E-Mail</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-5 mb-5">
                    <div class="col-xs-12 col-sm-6 col-lg-6">
                        <button type="submit" class="btn btn-primary">
                            Enviar link
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
