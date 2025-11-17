<?php

namespace App\Libraries\Validation;

class AudioValidation {
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
                'planId' => 'required|integer',
                'planName' => 'required|string|max_length[255]',
            ]
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
    ];

}