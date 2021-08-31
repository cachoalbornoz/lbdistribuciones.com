@extends('base.base')

@section('title', 'Listar usuarios')

@section('breadcrumb')
    {!! Breadcrumbs::render('users') !!}
@endsection

@section('content')

<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				Usuarios
				<small>
					<a href="{{ route('users.create') }}" class="btn btn-link">(+) Crear</a>
				</small>
            
            </div>

			<div class="card-body">
                <div class="detalle">
                    @include('admin.users.detalle')
                </div>
            </div>
		</div>
	</div>
</div>

@endsection

@section('js')

	<script>
	$(document).ready(function() {

        $('.send-type').on('change', function(){

			var token 		= $('input[name=_token]').val();

			$.ajax({
				url 	: $('.form-ajax').attr('action'),
				headers : {'X-CSRF-TOKEN': token},
				type 	: 'POST',
				dataType: 'json',
				data 	: { type : $("#type").val() },

				success: function(data){

                    $('.detalle').html(data)

				}
			});

			return false;
		})

        crearDataTable('users', 0, false);


	} );
	</script>

@endsection
