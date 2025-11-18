<?php

namespace App\Libraries\Validation;

class WebhooksValidation {

    public $routes = [
        'prod' => [
            'method' => 'POST,GET',
            'payload' => []
        ],
        'test' => [
            'method' => 'POST,GET',
            'payload' => []
        ],
    ];

}