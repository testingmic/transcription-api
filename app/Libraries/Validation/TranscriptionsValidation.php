<?php

// ==================== TranscriptionsValidation.php ====================
namespace App\Libraries\Validation;

class TranscriptionsValidation {

    public $routes = [
        'list' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'user', 'moderator'],
            'payload' => [
                'limit' => 'permit_empty|integer',
                'offset' => 'permit_empty|integer',
                'search' => 'permit_empty|string',
                'status' => 'permit_empty|string|in_list[PENDING,COMPLETED,FAILED,PROCESSING]',
                'start_date' => 'permit_empty|valid_date',
                'end_date' => 'permit_empty|valid_date',
            ]
        ],
        'view:transcription_id' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'user', 'moderator'],
            'payload' => [
                'transcription_id' => 'required|integer',
            ]
        ],
        'delete:transcription_id' => [
            'method' => 'DELETE',
            'authenticate' => true,
            'roles' => ['admin', 'user', 'moderator'],
            'payload' => [
                'transcription_id' => 'required|integer',
            ]
        ],
        'update:transcription_id' => [
            'method' => 'PUT',
            'authenticate' => true,
            'roles' => ['admin', 'user', 'moderator'],
            'payload' => [
                'transcription_id' => 'required|integer',
            ]
        ],
        'create' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['admin', 'user', 'moderator'],
            'payload' => [
                'status' => 'permit_empty|string|in_list[PENDING,COMPLETED,FAILED,PROCESSING]',
                'title' => 'required|string|max_length[255]',
                'description' => 'permit_empty|string|max_length[2000]',
                'transcription' => 'permit_empty|string|max_length[2000]',
                'summary' => 'permit_empty|string|max_length[2000]',
                'keywords' => 'permit_empty|string|max_length[2000]',
                'tags' => 'permit_empty|string|max_length[2000]',
            ]
        ],
        'upload' => [
            'method' => 'POST',
            'authenticate' => true,
            'roles' => ['admin', 'user', 'moderator'],
            'payload' => [
                'title' => 'required|string|max_length[255]',
                'description' => 'permit_empty|string|max_length[2000]',
                'summary' => 'permit_empty|string|max_length[2000]',
                'keywords' => 'permit_empty|string|max_length[2000]',
                'transcription' => 'permit_empty|string|max_length[2000]',
                'status' => 'permit_empty|string|in_list[PENDING,COMPLETED,FAILED,PROCESSING]',
                'tags' => 'permit_empty|string|max_length[2000]',
            ]
        ],
    ];
}