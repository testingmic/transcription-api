<?php

namespace App\Libraries\Validation;

class WebhooksValidation {

    public $routes = [
        'live' => [
            'method' => 'POST,GET',
            'payload' => []
        ],
        'test' => [
            'method' => 'POST,GET',
            'payload' => []
        ],
    ];

}