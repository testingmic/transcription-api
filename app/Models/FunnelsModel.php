<?php

// ==================== FunnelsModel.php ====================
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class FunnelsModel extends Model {
    
    protected $table = 'funnel_events_map';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'event_name', 'driver_id', 'pickup_id', 'contractor_id', 
        'household_id', 'event_date', 'created_at', 'updated_at'
    ];

    /**
     * Log a funnel event
     * @param string $eventName
     * @param array $data
     * @return int|bool
     */
    public function logEvent($eventName, $data = []) {
        try {
            $payload = [
                'event_name' => $eventName,
                'driver_id' => $data['driver_id'] ?? 0,
                'pickup_id' => $data['pickup_id'] ?? 0,
                'contractor_id' => $data['contractor_id'] ?? 0,
                'household_id' => $data['household_id'] ?? 0,
                'event_date' => $data['event_date'] ?? date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->insert($payload);
            return $this->insertID();
        } catch(DatabaseException $e) {
            log_message('error', 'Funnel Event Log Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Find funnel events
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findEvents($filters = [], $limit = null, $offset = 0) {
        $query = $this->select('funnel_events_map.*')
                     ->limit($limit, $offset * $limit);

        // Filter by event name
        if(!empty($filters['event_name'])) {
            if(is_array($filters['event_name'])) {
                $query->whereIn('event_name', $filters['event_name']);
            } else {
                $query->where('event_name', $filters['event_name']);
            }
        }

        // Filter by IDs
        foreach(['driver_id', 'pickup_id', 'contractor_id', 'household_id'] as $filter) {
            if(!empty($filters[$filter])) {
                if(is_array($filters[$filter])) {
                    $query->whereIn($filter, $filters[$filter]);
                } else {
                    $query->where($filter, $filters[$filter]);
                }
            }
        }

        // Add the date range filter
        if(!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->where('event_date >=', $filters['start_date']);
            $query->where('event_date <=', $filters['end_date']);
        } elseif(!empty($filters['start_date'])) {
            $query->where('event_date >=', $filters['start_date']);
        } elseif(!empty($filters['end_date'])) {
            $query->where('event_date <=', $filters['end_date']);
        }

        $query->orderBy('id', 'DESC');
        return $query->findAll();
    }

    /**
     * Count funnel events
     * @param array $filters
     * @return int
     */
    public function countEvents($filters = []) {
        $query = $this->builder();

        // Filter by event name
        if(!empty($filters['event_name'])) {
            if(is_array($filters['event_name'])) {
                $query->whereIn('event_name', $filters['event_name']);
            } else {
                $query->where('event_name', $filters['event_name']);
            }
        }

        // Filter by IDs
        foreach(['driver_id', 'pickup_id', 'contractor_id', 'household_id'] as $filter) {
            if(!empty($filters[$filter])) {
                if(is_array($filters[$filter])) {
                    $query->whereIn($filter, $filters[$filter]);
                } else {
                    $query->where($filter, $filters[$filter]);
                }
            }
        }

        // Add the date range filter
        if(!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->where('event_date >=', $filters['start_date']);
            $query->where('event_date <=', $filters['end_date']);
        } elseif(!empty($filters['start_date'])) {
            $query->where('event_date >=', $filters['start_date']);
        } elseif(!empty($filters['end_date'])) {
            $query->where('event_date <=', $filters['end_date']);
        }

        return $query->countAllResults();
    }

    /**
     * Get event statistics
     * @param array $filters
     * @return array
     */
    public function getEventStatistics($filters = []) {
        $query = $this->db->table($this->table)
                         ->select('event_name, COUNT(*) as count')
                         ->groupBy('event_name');

        // Filter by IDs
        foreach(['driver_id', 'pickup_id', 'contractor_id', 'household_id'] as $filter) {
            if(!empty($filters[$filter])) {
                $query->where($filter, $filters[$filter]);
            }
        }

        // Add the date range filter
        if(!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->where('event_date >=', $filters['start_date']);
            $query->where('event_date <=', $filters['end_date']);
        }

        return $query->get()->getResultArray();
    }

    /**
     * Get events by date
     * @param array $filters
     * @return array
     */
    public function getEventsByDate($filters = []) {
        $query = $this->db->table($this->table)
                         ->select('event_date, event_name, COUNT(*) as count')
                         ->groupBy('event_date, event_name')
                         ->orderBy('event_date', 'DESC');

        // Filter by event name
        if(!empty($filters['event_name'])) {
            if(is_array($filters['event_name'])) {
                $query->whereIn('event_name', $filters['event_name']);
            } else {
                $query->where('event_name', $filters['event_name']);
            }
        }

        // Filter by IDs
        foreach(['driver_id', 'pickup_id', 'contractor_id', 'household_id'] as $filter) {
            if(!empty($filters[$filter])) {
                $query->where($filter, $filters[$filter]);
            }
        }

        // Add the date range filter
        if(!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->where('event_date >=', $filters['start_date']);
            $query->where('event_date <=', $filters['end_date']);
        }

        return $query->get()->getResultArray();
    }

    /**
     * Get funnel conversion rates
     * @param array $filters
     * @return array
     */
    public function getFunnelConversionRates($filters = []) {
        $events = $this->getEventStatistics($filters);
        
        $funnelData = [];
        foreach($events as $event) {
            $funnelData[$event['event_name']] = (int)$event['count'];
        }

        return $funnelData;
    }

    /**
     * Delete old events (for cleanup)
     * @param string $beforeDate
     * @return bool
     */
    public function deleteOldEvents($beforeDate) {
        try {
            return $this->where('event_date <', $beforeDate)->delete();
        } catch(DatabaseException $e) {
            log_message('error', 'Funnel Event Delete Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if event exists
     * @param array $filters
     * @return array|null
     */
    public function checkEventExists($filters = []) {
        $query = $this->builder();
        foreach($filters as $key => $value) {
            if(is_array($value)) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }
        return $query->get()->getRowArray();
    }
}
