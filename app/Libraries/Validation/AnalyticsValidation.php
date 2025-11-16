<?php

// ==================== AnalyticsValidation.php ====================
namespace App\Libraries\Validation;

class AnalyticsValidation {
    public $routes = [
        'dashboard' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'assembly', 'contractor', 'driver', 'household', 'tricycle'],
            'payload' => [
                'contractor_id' => 'permit_empty|integer',
                'jurisdiction_id' => 'permit_empty|integer',
                'period' => 'permit_empty|in_list[today,week,month,year]',
            ]
        ],
        'pickupTrends' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'assembly', 'contractor', 'driver', 'household', 'tricycle'],
            'payload' => [
                'contractor_id' => 'permit_empty|integer',
                'start_date' => 'required|valid_date',
                'end_date' => 'required|valid_date',
                'group_by' => 'permit_empty|in_list[day,week,month]',
            ]
        ],
        'heatmap' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'assembly', 'contractor', 'driver'],
            'payload' => [
                'jurisdiction_id' => 'required|integer',
                'date' => 'permit_empty|valid_date',
            ]
        ],
        'efficiencyMetrics' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'assembly', 'contractor'],
            'payload' => [
                'contractor_id' => 'permit_empty|integer',
                'start_date' => 'required|valid_date',
                'end_date' => 'required|valid_date',
            ]
        ],
    ];
}
