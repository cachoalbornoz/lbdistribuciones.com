<?php

$factory->define(App\Models\Contacto::class, function (Faker\Generator $faker) {

    return [
        'nombreempresa' => $faker->company,
        'apellido'      => $faker->lastName,
        'nombres'       => $faker->name, 
        'email'         => $faker->email,
        'cuit'          => '20232546132',
        'ciudad'        => 2548

    ];
});

$factory->define(App\Models\Proveedor::class, function (Faker\Generator $faker) {

    return [
        'nombreempresa'     => $faker->company,
        'apellido'          => $faker->lastName,
        'nombres'           => $faker->name, 
        'email'             => $faker->email,
        'cuit'              => '30232546132',
        'ciudad'            => 2548,
        'tiporesponsable'   => 2

    ];
});

$factory->define(App\Models\Producto::class, function (Faker\Generator $faker) {

    return [
    	'codigobarra'	=> $faker->ean13, 
        'nombre' 		=> $faker->company,
        'descripcion'   => $faker->lastName,
        'preciocosto'   => 5, 
        'precioventa'   => 5, 
        'stockaviso'   	=> 2,
        'stockactual'   => 20,
        'activo'        => 1,
        'marca'   		=> 1,
        'rubro'			=> 1,
        

    ];
});
