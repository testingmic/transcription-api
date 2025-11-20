<?php

namespace App\Libraries\Validation;

class UsersValidation {

    public $routes = [
        'deactivate:user_id' => [
            'method' => 'POST',
            'authenticate' => true,
            'payload' => [
                "user_id" => "required|integer"
            ]
        ],
        'me' => [
            'method' => 'GET',
            'authenticate' => true,
            'payload' => []
        ],
        'subscription' => [
            'method' => 'GET',
            'authenticate' => true,
            'payload' => []
        ],
        'profile' => [
            'method' => 'GET',
            'authenticate' => true,
            'payload' => []
        ],
        'list' => [
            'method' => 'GET',
            'authenticate' => true,
            'payload' => [
                "limit" => "permit_empty|integer",
                "offset" => "permit_empty|integer",
                "search" => "permit_empty|string",
                "status" => "permit_empty|string",
                "role" => "permit_empty|string|in_list[User,Admin]"
            ]
        ],
        'delete:user_id' => [
            'method' => 'DELETE',
            'authenticate' => true,
            'payload' => [
                "user_id" => "required|integer"
            ]
        ],
        'reactivate:user_id' => [
            'method' => 'POST',
            'authenticate' => true,
            'payload' => [
                "user_id" => "required|integer"
            ]
        ],
        'view:user_id' => [
            'method' => 'GET',
            'authenticate' => true,
            'payload' => [
                "user_id" => "required|integer"
            ]
        ],
        'create' => [
            'method' => 'POST',
            'payload' => [
                "name" => "required|string|max_length[255]",
                "email" => "required|string|max_length[255]",
                "phone" => "permit_empty|string|max_length[255]",
                "preferences" => "permit_empty|is_array|max_length[10]",
                "password" => "required|valid_password|max_length[255]|min_length[6]",
                "organizationName" => "permit_empty|string|max_length[255]",
                "confirmPassword" => "required|valid_password|max_length[255]|min_length[6]|matches[password]",
                "role" => "required|string|in_list[User,Admin]"
            ]
        ],
        'update:user_id' => [
            'method' => 'POST',
            'authenticate' => true,
            'payload' => [
                "name" => "permit_empty",
                "user_id" => "required|integer",
                "description" => "permit_empty|string|max_length[2000]",
                "nationality" => "permit_empty|string|max_length[255]",
                "gender" => "permit_empty|string|max_length[255]|in_list[Male,Female]",
                "date_of_birth" => "permit_empty|string|max_length[255]|valid_date",
                "phone" => "permit_empty|string|max_length[255]",
                "billing_address" => "permit_empty|string|max_length[255]",
            ]
        ],
        'analytics' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator'],
            'payload' => [
                'start_date' => 'permit_empty|valid_date[Y-m-d]',
                'end_date' => 'permit_empty|valid_date[Y-m-d]',
                'period' => 'permit_empty|string|in_list[7d,30d,90d,1y,all]',
            ]
        ]
    ];

}

?>