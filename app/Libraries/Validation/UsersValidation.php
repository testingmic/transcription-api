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
                "password" => "required|valid_password|max_length[255]",
                "organizationName" => "permit_empty|string|max_length[255]",
                "confirmPassword" => "required|valid_password|max_length[255]|matches[password]",
                "role" => "required|string|in_list[User,Admin]"
            ]
        ],
        'update:user_id' => [
            'method' => 'PUT',
            'authenticate' => true,
            'payload' => [
                "user_id" => "required|integer",
                "description" => "permit_empty|string|max_length[2000]",
                "nationality" => "permit_empty|string|max_length[255]",
                "gender" => "permit_empty|string|max_length[255]|in_list[Male,Female]",
                "date_of_birth" => "permit_empty|string|max_length[255]|valid_date",
                "phone" => "permit_empty|string|max_length[255]",
                "billing_address" => "permit_empty|string|max_length[255]",
                "name" => "permit_empty|string|max_length[255]",
                "timezone" => "permit_empty|string|max_length[255]",
                "organizationName" => "permit_empty|string|max_length[255]",
                "website" => "permit_empty|string|max_length[255]",
                "company" => "permit_empty|string|max_length[255]",
                "job_title" => "permit_empty|string|max_length[255]",
                "email" => "permit_empty|string|max_length[255]",
                "language" => "permit_empty|string|max_length[255]",
                "phone" => "permit_empty|string|max_length[255]",
                "preferences" => "permit_empty|is_array|max_length[10]",
                "social_links" => "permit_empty|is_array|max_length[5]",
                "skills" => "permit_empty|string|max_length[500]",
                "organizationType" => "permit_empty|string|max_length[255]|in_list[school,church,organization,individual]"
            ]
        ]
    ];

}

?>