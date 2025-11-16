<?php

// ==================== FunnelsValidation.php ====================
namespace App\Libraries\Validation;

class FunnelsValidation {
    public $routes = [
        'list' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'assembly', 'contractor', 'driver', 'tricycle', 'household'],
            'payload' => [
                'limit' => 'permit_empty|integer',
                'offset' => 'permit_empty|integer',
                'event_name' => 'permit_empty|string|max_length[100]',
                'driver_id' => 'permit_empty|integer',
                'pickup_id' => 'permit_empty|integer',
                'contractor_id' => 'permit_empty|integer',
                'household_id' => 'permit_empty|integer',
                'start_date' => 'permit_empty|valid_date',
                'end_date' => 'permit_empty|valid_date',
            ]
        ],
        'log' => [
            'method' => 'POST',
            'authenticate' => false, // Can be called globally
            'roles' => ['admin', 'assembly', 'contractor', 'driver', 'tricycle', 'household'],
            'payload' => [
                'event_name' => 'required|string|max_length[100]',
                'driver_id' => 'permit_empty|integer',
                'pickup_id' => 'permit_empty|integer',
                'contractor_id' => 'permit_empty|integer',
                'household_id' => 'permit_empty|integer',
                'event_date' => 'permit_empty|valid_date',
            ]
        ],
        'statistics' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'assembly', 'contractor'],
            'payload' => [
                'event_name' => 'permit_empty|string|max_length[100]',
                'driver_id' => 'permit_empty|integer',
                'pickup_id' => 'permit_empty|integer',
                'contractor_id' => 'permit_empty|integer',
                'household_id' => 'permit_empty|integer',
                'start_date' => 'permit_empty|valid_date',
                'end_date' => 'permit_empty|valid_date',
            ]
        ],
        'conversions' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'assembly', 'contractor'],
            'payload' => [
                'driver_id' => 'permit_empty|integer',
                'pickup_id' => 'permit_empty|integer',
                'contractor_id' => 'permit_empty|integer',
                'household_id' => 'permit_empty|integer',
                'start_date' => 'permit_empty|valid_date',
                'end_date' => 'permit_empty|valid_date',
            ]
        ],
        'byDate' => [
            'method' => 'GET',
            'authenticate' => true,
            'roles' => ['admin', 'assembly', 'contractor'],
            'payload' => [
                'event_name' => 'permit_empty|string|max_length[100]',
                'driver_id' => 'permit_empty|integer',
                'pickup_id' => 'permit_empty|integer',
                'contractor_id' => 'permit_empty|integer',
                'household_id' => 'permit_empty|integer',
                'start_date' => 'permit_empty|valid_date',
                'end_date' => 'permit_empty|valid_date',
            ]
        ],
    ];
}
