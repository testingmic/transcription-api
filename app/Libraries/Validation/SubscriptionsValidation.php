<?php

namespace App\Libraries\Validation;

class SubscriptionsValidation {
    public $routes = [
        'plans' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
        ],
        'initialize' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
        ],
        'checkout' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
        ]
    ];
}