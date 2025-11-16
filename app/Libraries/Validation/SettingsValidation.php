<?php

namespace App\Libraries\Validation;

class SettingsValidation {

    public $routes = [
        'theme' => [
            'method' => 'POST,GET',
            'payload' => [
                'theme' => 'required|in_list[light,dark]'
            ]
        ]
    ];
    
}