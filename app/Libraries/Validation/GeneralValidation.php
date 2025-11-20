<?php

namespace App\Libraries\Validation;

class GeneralValidation {
    public $routes = [
        'utilities' => [
            'method' => 'GET',
            'authenticate' => false,
            'payload' => []
        ],
        'leave' => [
            'method' => 'POST',
            'authenticate' => false,
            'payload' => [
                "email" => "required|valid_email|max_length[255]",
                "reason" => "required|string|max_length[255]",
                "comments" => "permit_empty|string|max_length[255]"
            ]
        ],
        'requests' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator'],
            'payload' => []
        ],
        'legal' => [
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
        'health' => [
            'method' => 'GET,POST',
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => []
        ],
        'event' => [
            'method' => 'POST',
            'authenticate' => false,
            'payload' => []
        ]
    ];

}

