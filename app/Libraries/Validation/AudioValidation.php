<?php

namespace App\Libraries\Validation;

class AudioValidation {
    public $routes = [
        'list' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'moderator', 'user'],
            'payload' => [
                'limit' => 'permit_empty|integer',
                'offset' => 'permit_empty|integer',
                'transcription_id' => 'permit_empty|integer',
            ]
        ],
        'create' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['admin', 'moderator', 'user'],
            'payload' => [
                'transcription_id' => 'required|integer',
                'audio' => 'required',
                'mimeType' => 'required|string|max_length[255]',
                'size' => 'required|integer',
            ]
        ],
        'view:audio_id' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'moderator', 'user'],
            'payload' => [
                'audio_id' => 'required|integer',
            ]
        ],
        'delete:audio_id' => [
            'method' => 'DELETE',
            'authenticate' => true,
            'roles' => ['admin', 'moderator', 'user'],
            'payload' => [
                'audio_id' => 'required|integer',
            ]
        ],
    ];

}