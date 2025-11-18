<?php

namespace App\Libraries\Validation;

class NotificationsValidation {

    public $routes = [
        'list' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'limit' => 'permit_empty|integer',
                'offset' => 'permit_empty|integer',
                'type' => 'permit_empty|string|max_length[50]',
                'read' => 'permit_empty|string|in_list[true,false]',
                'user_id' => 'permit_empty|integer',
            ]
        ],
        'view:notification_id' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'notification_id' => 'required|integer'
            ]
        ],
        'create' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['Admin']
        ],
        'update:notification_id' => [
            'method' => 'PUT',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator'],
            'payload' => [
                'notification_id' => 'required|integer'
            ]
        ],
        'delete:notification_id' => [
            'method' => 'DELETE',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'notification_id' => 'required|integer'
            ]
        ],
        'read' => [
            'method' => 'POST,PUT',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'notification_id' => 'required|integer'
            ]
        ],
        'readall' => [
            'method' => 'POST,PUT',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User']
        ],
    ];

}

