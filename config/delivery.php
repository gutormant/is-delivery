<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Company delivery info params and delivery services options
    |--------------------------------------------------------------------------
    */

    'company' => [
        'address' => 'data from application config'
    ],
    'services' => [
        'nova_post' => [
            'host' => 'novaposhta.test',
            'urls' => [
                'parcel_info_send' => '/api/delivery'
            ]
        ],
    ]
];
