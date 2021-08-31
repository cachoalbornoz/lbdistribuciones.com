<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect, URL, Artisan;

class InicioController extends Controller
{

	public function index() {
		
		return view('base.home');		
	}

	public function frontend() {
		
		return view('base.frontend');		
	}

	public function limpiar(){

		Artisan::call('optimize');
		Artisan::call('route:clear'); 
		Artisan::call('config:cache');
		Artisan::call('view:clear');
		Artisan::call('cache:clear');

		echo (Artisan::output() . 'Sistema limpio !');
		
	}

}
