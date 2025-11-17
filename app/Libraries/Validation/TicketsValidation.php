<?php

namespace App\Libraries\Validation;

class TicketsValidation {

    /**
     * Routes for the Tickets model
     * @var array
     * 
     * tickets/status
     * tickets/view/:ticket_id
     * tickets/create
     * tickets/update/:ticket_id
     * tickets/delete/:ticket_id
     * tickets/email
     * tickets/status
     * tickets/close
     * tickets/messages
     */
    public $routes = [
        'list' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'limit' => 'permit_empty|integer',
                'offset' => 'permit_empty|integer',
            ]
        ],
        'view:ticket_id' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'ticket_id' => 'required|integer',
            ]
        ],
        'create' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'subject' => 'required|string|max_length[255]',
                'description' => 'required|string|max_length[1000]',
                'priority' => 'required|string|in_list[low,medium,high,urgent]',
                'type' => 'required|string|in_list[support,billing,technical,ticket]',
            ]
        ],
        'update:ticket_id' => [
            'method' => 'PUT',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'ticket_id' => 'required|integer',
            ]
        ],
        'delete:ticket_id' => [
            'method' => 'DELETE',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'ticket_id' => 'required|integer',
            ]
        ],
        'email' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
            ]
        ],
        'status:ticket_id' => [
            'method' => 'POST,PUT',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'ticket_id' => 'required|integer',
                'status' => 'required|string|in_list[open,in_progress,resolved,closed]',
            ]
        ],
        'messages:ticket_id' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'ticket_id' => 'required|integer',
                'message' => 'required|string'
            ]
        ],
        'close:ticket_id' => [
            'method' => 'POST,PUT',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'ticket_id' => 'required|integer',
            ]
        ]
    ];
}