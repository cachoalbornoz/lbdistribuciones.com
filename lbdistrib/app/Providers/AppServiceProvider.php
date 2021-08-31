<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Models\Pedido,
    App\Models\Producto,
    App\Models\Presupuesto,
    App\Models\Contacto ;

use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(120);

        // Nro de registros
        $nro_pedidos        = Pedido::activo()->count(); 
        $nro_presupuestos   = Presupuesto::activo()->count(); 
        $nro_contactos      = Contacto::count();
        $nro_productos      = Producto::count();

        View::share(['nro_pedidos'=> $nro_pedidos, 'nro_presupuestos'=> $nro_presupuestos, 'nro_contactos' => $nro_contactos, 'nro_productos' => $nro_productos]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
