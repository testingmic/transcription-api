<?php

// ==================== funnel_helper.php ====================

if (!function_exists('logFunnelEvent')) {
    /**
     * Log a funnel event globally
     * 
     * @param string $eventName The name of the event to log
     * @param array $data Additional data for the event
     * @return int|bool Event ID on success, false on failure
     */
    function logFunnelEvent($eventName, $data = []) {
        try {
            $funnelsModel = new \App\Models\FunnelsModel();
            
            $eventData = [
                'driver_id' => $data['driver_id'] ?? 0,
                'pickup_id' => $data['pickup_id'] ?? 0,
                'contractor_id' => $data['contractor_id'] ?? 0,
                'household_id' => $data['household_id'] ?? 0,
                'event_date' => $data['event_date'] ?? date('Y-m-d'),
            ];
            
            return $funnelsModel->logEvent($eventName, $eventData);
        } catch (\Exception $e) {
            log_message('error', 'Failed to log funnel event: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('formatFunnelEvent')) {
    /**
     * Format a funnel event for API response
     * 
     * @param array $event
     * @return array|null
     */
    function formatFunnelEvent($event) {
        if(empty($event)) return null;

        return [
            'id' => (int) $event['id'],
            'event_name' => $event['event_name'],
            'driver_id' => (int) $event['driver_id'],
            'pickup_id' => (int) $event['pickup_id'],
            'contractor_id' => (int) $event['contractor_id'],
            'household_id' => (int) $event['household_id'],
            'event_date' => $event['event_date'],
            'created_at' => $event['created_at'],
            'updated_at' => $event['updated_at'],
        ];
    }
}

if (!function_exists('formatFunnelEventsList')) {
    /**
     * Format a list of funnel events for API response
     * 
     * @param array $events
     * @return array
     */
    function formatFunnelEventsList($events) {
        if(empty($events)) return [];
        return array_map('formatFunnelEvent', $events);
    }
}

if (!function_exists('logPickupEvent')) {
    /**
     * Log a pickup-related funnel event
     * 
     * @param string $eventName
     * @param int $pickupId
     * @param array $additionalData
     * @return int|bool
     */
    function logPickupEvent($eventName, $pickupId, $additionalData = []) {
        $data = array_merge([
            'pickup_id' => $pickupId,
        ], $additionalData);
        
        return logFunnelEvent($eventName, $data);
    }
}

if (!function_exists('logHouseholdEvent')) {
    /**
     * Log a household-related funnel event
     * 
     * @param string $eventName
     * @param int $householdId
     * @param array $additionalData
     * @return int|bool
     */
    function logHouseholdEvent($eventName, $householdId, $additionalData = []) {
        $data = array_merge([
            'household_id' => $householdId,
        ], $additionalData);
        
        return logFunnelEvent($eventName, $data);
    }
}

if (!function_exists('logDriverEvent')) {
    /**
     * Log a driver-related funnel event
     * 
     * @param string $eventName
     * @param int $driverId
     * @param array $additionalData
     * @return int|bool
     */
    function logDriverEvent($eventName, $driverId, $additionalData = []) {
        $data = array_merge([
            'driver_id' => $driverId,
        ], $additionalData);
        
        return logFunnelEvent($eventName, $data);
    }
}

if (!function_exists('logContractorEvent')) {
    /**
     * Log a contractor-related funnel event
     * 
     * @param string $eventName
     * @param int $contractorId
     * @param array $additionalData
     * @return int|bool
     */
    function logContractorEvent($eventName, $contractorId, $additionalData = []) {
        $data = array_merge([
            'contractor_id' => $contractorId,
        ], $additionalData);
        
        return logFunnelEvent($eventName, $data);
    }
}
