<?php

return [

    'default' => env('MAIL_MAILER', 'smtp'),

    'mailers' => [
        'smtp' => [
            'transport'  => 'smtp',
            'host'       => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port'       => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username'   => env('MAIL_USERNAME'),
            'password'   => env('MAIL_PASSWORD'),
            'timeout'    => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ],
        'log' => [
            'transport' => 'log',
            'channel'   => env('MAIL_LOG_CHANNEL'),
        ],
        'array' => [
            'transport' => 'array',
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name'    => env('MAIL_FROM_NAME', 'Portfolio'),
    ],


    // Interview requests booked from the talent bench.
    'talent' => [
        'to' => array_values(array_filter(array_map('trim', explode(',', (string) env('MAIL_TALENT_TO', 'hello@isla.com.au'))))),
        'cc' => array_values(array_filter(array_map('trim', explode(',', (string) env('MAIL_TALENT_CC', ''))))),
    ],

    'enquiry' => [
        'to' => array_values(array_filter(array_map('trim', explode(',', (string) env('MAIL_ENQUIRY_TO', 'hello@islavasolution.net'))))),
        'cc' => array_values(array_filter(array_map('trim', explode(',', (string) env('MAIL_ENQUIRY_CC', 'hello@islavasolution.net,cpe.villanueva.gabrielandrei@gmail.com'))))),
    ],
];
