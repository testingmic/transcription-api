<?php

namespace App\Libraries\Validation;

class PaymentsValidation {
    public $routes = [
        'history' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'limit' => 'permit_empty|integer',
                'offset' => 'permit_empty|integer',
                'user_id' => 'permit_empty|integer',
            ]
        ],
        'initialize' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'email' => 'required|valid_email|max_length[255]',
                'amount' => 'required|numeric',
                'planId' => 'required|string',
                'planName' => 'required|string|max_length[255]',
            ]
        ],
        'verify' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'reference' => 'required|string|max_length[32]',
                'planId' => 'required|string|max_length[32]',
            ]
        ],
        'history' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [ ]
        ],
        'list' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'limit' => 'permit_empty|integer',
                'offset' => 'permit_empty|integer',
                'status' => 'permit_empty|string|max_length[32]',
                'user_id' => 'permit_empty|integer',
            ]
        ],
        'view:payment_id' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User']
        ],
        'revenue' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'start_date' => 'permit_empty|valid_date[Y-m-d]',
                'end_date' => 'permit_empty|valid_date[Y-m-d]',
            ]
        ],
    ];

}