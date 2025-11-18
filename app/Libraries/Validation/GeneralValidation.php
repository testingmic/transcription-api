<?php

namespace App\Libraries\Validation;

class GeneralValidation {
    public $routes = [
        'utilities' => [
            'method' => 'GET',
            'authenticate' => false,
            'payload' => []
        ],
        'endpoints' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => []
        ],
        'stats' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator'],
            'payload' => []
        ],
    ];

}

