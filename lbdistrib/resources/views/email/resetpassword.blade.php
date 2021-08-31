<div class="card">
    <div class="card-header">
        Hola <b>{{ $destinatario }}</b>,
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                {{ $mensaje }} <em> <a href="{{ url('reset-password/'.$token)}}">link de acceso</a> </em>
            </div>
        </div>
    </div>
</div>
