<?php 
/**
 * File: app/Controllers/Funnels/Funnels.php
 * Funnel Event Tracking Controller
 */
namespace App\Controllers\Funnels;

use App\Controllers\LoadController;
use App\Libraries\Routing;
use App\Models\FunnelsModel;

class Funnels extends LoadController {

    protected $funnelsModel;

    public function __construct() {
        parent::__construct();
        $this->funnelsModel = new FunnelsModel();
    }

    /**
     * List funnel events
     * @return mixed
     */
    public function list() {
        $filters = [
            'event_name' => $this->payload['event_name'] ?? null,
            'driver_id' => $this->payload['driver_id'] ?? null,
            'pickup_id' => $this->payload['pickup_id'] ?? null,
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'household_id' => $this->payload['household_id'] ?? null,
            'start_date' => $this->payload['start_date'] ?? null,
            'end_date' => $this->payload['end_date'] ?? null,
        ];

        // Filter by user role
        if($this->isHousehold()) {
            $filters['household_id'] = $this->uniqueId;
        } elseif($this->isContractor()) {
            $filters['contractor_id'] = $this->currentUser['contractor_id'] ?? 0;
        } elseif($this->isDriver() || $this->isTricycle()) {
            $filters['driver_id'] = $this->currentUser['id'] ?? 0;
        } elseif($this->isAssembly()) {
            $filters['assembly_id'] = $this->currentUser['assembly_id'] ?? 0;
        }

        $data = $this->funnelsModel->findEvents(
            $filters, 
            $this->payload['limit'] ?? $this->defaultLimit, 
            $this->payload['offset'] ?? 0
        );
        
        $total = $this->funnelsModel->countEvents($filters);

        return Routing::success([
            'data' => $data, 
            'pagination' => [
                'total' => $total, 
                'limit' => $this->payload['limit'] ?? $this->defaultLimit, 
                'offset' => $this->payload['offset'] ?? 0
            ]
        ]);
    }

    /**
     * Log a funnel event
     * @return mixed
     */
    public function log() {
        $eventName = $this->payload['event_name'] ?? null;
        
        if(empty($eventName)) {
            return Routing::error('Event name is required');
        }

        $data = [
            'driver_id' => $this->payload['driver_id'] ?? 0,
            'pickup_id' => $this->payload['pickup_id'] ?? 0,
            'contractor_id' => $this->payload['contractor_id'] ?? 0,
            'household_id' => $this->payload['household_id'] ?? 0,
            'event_date' => $this->payload['event_date'] ?? date('Y-m-d'),
        ];

        $eventId = $this->funnelsModel->logEvent($eventName, $data);
        
        if(!$eventId) {
            return Routing::error('Failed to log event');
        }

        return Routing::success([
            'message' => 'Event logged successfully', 
            'event_id' => $eventId
        ]);
    }

    /**
     * Get funnel statistics
     * @return mixed
     */
    public function statistics() {
        $filters = [
            'event_name' => $this->payload['event_name'] ?? null,
            'driver_id' => $this->payload['driver_id'] ?? null,
            'pickup_id' => $this->payload['pickup_id'] ?? null,
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'household_id' => $this->payload['household_id'] ?? null,
            'start_date' => $this->payload['start_date'] ?? null,
            'end_date' => $this->payload['end_date'] ?? null,
        ];

        // Filter by user role
        if(!empty($this->currentUser)) {
            if($this->currentUser['role'] == 'contractor') {
                $filters['contractor_id'] = $this->currentUser['contractor_id'] ?? 0;
            }
        }

        $stats = $this->funnelsModel->getEventStatistics($filters);
        
        return Routing::success(['statistics' => $stats]);
    }

    /**
     * Get funnel conversion rates
     * @return mixed
     */
    public function conversions() {
        $filters = [
            'driver_id' => $this->payload['driver_id'] ?? null,
            'pickup_id' => $this->payload['pickup_id'] ?? null,
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'household_id' => $this->payload['household_id'] ?? null,
            'start_date' => $this->payload['start_date'] ?? null,
            'end_date' => $this->payload['end_date'] ?? null,
        ];

        // Filter by user role
        if(!empty($this->currentUser)) {
            if($this->currentUser['role'] == 'contractor') {
                $filters['contractor_id'] = $this->currentUser['contractor_id'] ?? 0;
            }
        }

        $conversions = $this->funnelsModel->getFunnelConversionRates($filters);
        
        return Routing::success(['conversions' => $conversions]);
    }

    /**
     * Get events by date
     * @return mixed
     */
    public function byDate() {
        $filters = [
            'event_name' => $this->payload['event_name'] ?? null,
            'driver_id' => $this->payload['driver_id'] ?? null,
            'pickup_id' => $this->payload['pickup_id'] ?? null,
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'household_id' => $this->payload['household_id'] ?? null,
            'start_date' => $this->payload['start_date'] ?? null,
            'end_date' => $this->payload['end_date'] ?? null,
        ];

        // Filter by user role
        if(!empty($this->currentUser)) {
            if($this->currentUser['role'] == 'contractor') {
                $filters['contractor_id'] = $this->currentUser['contractor_id'] ?? 0;
            }
        }

        $data = $this->funnelsModel->getEventsByDate($filters);
        
        return Routing::success(['data' => $data]);
    }
}
