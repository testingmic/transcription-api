<?php

// ==================== AnalyticsValidation.php ====================
namespace App\Libraries\Validation;

class AnalyticsValidation {
    public $routes = [
        'dashboard' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'contractor_id' => 'permit_empty|integer',
                'jurisdiction_id' => 'permit_empty|integer',
                'period' => 'permit_empty|in_list[today,week,month,year]',
            ]
        ],
        'heatmap' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['Admin', 'Moderator', 'User'],
            'payload' => [
                'jurisdiction_id' => 'required|integer',
                'date' => 'permit_empty|valid_date',
            ]
        ]
    ];
}
