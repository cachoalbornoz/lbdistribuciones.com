<?php

return [

    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.hostinger.com.ar'),
    'port' => env('MAIL_PORT', 645),
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'info@lbdistribuciones.com'),
        'name' => env('MAIL_FROM_NAME', 'Soporte'),
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'ssl'),
    'username' => env('MAIL_USERNAME', 'info@lbdistribuciones.com'),
    'password' => env('MAIL_PASSWORD', 'Cervantes69'),
    'sendmail' => '/usr/sbin/sendmail -bs',

];
