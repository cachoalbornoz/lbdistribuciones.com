@extends('base.base')

@section('title', 'Acceso')

@section('content')

<div class="container">

    <div class="row mt-3">
        <div class="col-xs-12 col-md-6 col-lg-6 mx-auto">
            <div class="card">

                <div class="card-header">
                    <h4 class="text-center">Ingreso al sistema</h4>
                </div>

                <div class="card-body">
                    <form role="form" method="POST" action="{{ url('/login') }}" autocomplete="off">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="row mb-5">
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                    <label for="email">Correo electrónico</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="row mb-5">
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                    <label for="password">Contraseña</label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control" name="password" required>
                                        <div class=" input-group-append">
                                            <span class="input-group-text">
                                                <span class="fa fa-eye" id="mostrar"></span>
                                            </span>
                                        </div>
                                    </div>

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row mb-5">
                            <div class="col-xs-12 col-sm-12 col-lg-12">
                                <button type="submit" class="btn btn-block btn-primary">
                                    Acceder
                                </button>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-12 col-lg-12">
                                <a class=" text-black-50" href="{{ url('/password/reset') }}">
                                    Olvidaste tu clave ?
                                </a>
                            </div>
                        </div>

                    </form>

                    @if ($message = Session::get('warning'))
                    <div class="card-footer alert alert-danger text-center">
                        <strong>Gmail :: </strong> {{ $message }}
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script>
    $('div.alert').not('.alert-important').delay(5000).fadeOut(500);

    $('#mostrar').on('click', function () {

        var x = $("#password").attr("type");

        if (x === "password") {

            $("#password").attr("type", "text");

        } else {

            $("#password").attr("type", "password");
        }
    });

</script>
@endsection