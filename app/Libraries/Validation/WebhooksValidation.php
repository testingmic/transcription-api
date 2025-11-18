<?php

namespace App\Libraries\Validation;

class WebhooksValidation {

    public $routes = [
        'prod' => [
            'method' => 'POST',
            'payload' => []
        ],
        'test' => [
            'method' => 'POST',
            'payload' => []
        ],
    ];

}