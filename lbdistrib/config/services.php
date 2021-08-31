<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [      
       'client_id'      => env('101616744885-ciqcqieqd9e7ogp0gnosk81aim1079o7.apps.googleusercontent.com'), 
       'client_secret'  => env('rgKHXQSeyPA7rMDUR09bouKg'),
       'redirect'       => env('http://localhost/lbdistribl/auth/google/callback'),
       'api_key'        => env('AIzaSyBYlLZKR68iQxDEErLtwD4hwwaj9_cJk0Q'),
    ],
];
