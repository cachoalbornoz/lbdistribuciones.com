@if (Auth::guest())
	<div class="footer">
		<div class="container-fluid border shadow bg-dark text-white text-center">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-lg-6 d-none d-sm-block">
					<small><i class="fa fa-diamond" aria-hidden="true"></i> Desarrollo :: Guillermo Albornoz - <?= date('Y', time());?> </small> 	
				</div>
				<div class="col-xs-12 col-sm-6 col-lg-6">
					<small>Contacto (343) 4586951 / cachoalbornoz@gmail.com</small>	
				</div>		
			</div>
		</div>
	</div>
@endif	