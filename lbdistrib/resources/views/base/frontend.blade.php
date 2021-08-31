@extends('base.base')

@section('title', 'Inicio')

@section('content')

    <div class="container">

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
			&nbsp;
		</div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-9 col-lg-9">

			<div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
					<img class="d-block w-100" src="{{ asset('images/frontend/template-homepage.png')}}" alt="Primera imagen">
					</div>
					<div class="carousel-item">
					<img class="d-block w-100" src="{{ asset('images/frontend/ferreteria2.png')}}" alt="Segunda imagen">
					</div>
					<div class="carousel-item">
					<img class="d-block w-100" src="{{ asset('images/frontend/ferreteria1.jpg')}}" alt="Tercera imagen">
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previo</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Siguiente</span>
				</a>
			</div>

        </div>

        <div class="col-xs-12 col-sm-3 col-lg-3 text-center">
			<h5>
				<i class="fa fa-info-circle" aria-hidden="true"></i> 
				Atención al cliente
			</h5>
			
			<hr class="mb-3">

			<p class="font-weight-bold mb-3">Butus Luis Leonardo</p>
			
			<p class="m-2">lbrepresentaciones@hotmail.com</p>
			<p class="m-2"><i class="fa fa-whatsapp text-success" aria-hidden="true"></i> 0343 - 154 539077</p>
			<p class="m-2">Cuit 20-22514563-8</p>

			<hr class="mb-3">

			<p class="font-weight-bold mb-3">Butus Juan Carlos</p>
			
			<p class="m-2">jbutus@hotmail.com</p>
			<p class="m-2"><i class="fa fa-whatsapp text-success" aria-hidden="true"></i> 0343 -155 104769</p>
			<p class="m-2">Cuit 20-26809087-9</p>	
			

		</div>
      </div>

	  <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
			&nbsp;
		</div>
      </div>

	  <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
			&nbsp;
		</div>
      </div>

    </div>


@endsection
