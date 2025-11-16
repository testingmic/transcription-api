<?php

// ==================== analytics_helper.php ====================

if (!function_exists('calculateEfficiencyRate')) {
    function calculateEfficiencyRate($completed, $total) {
        if($total == 0) return 0;
        return round(($completed / $total) * 100, 2);
    }
}

if (!function_exists('formatAnalyticsData')) {
    function formatAnalyticsData($data) {
        return [
            'total_pickups' => (int) ($data['total_pickups'] ?? 0),
            'completed_pickups' => (int) ($data['completed_pickups'] ?? 0),
            'missed_pickups' => (int) ($data['missed_pickups'] ?? 0),
            'pending_pickups' => (int) ($data['pending_pickups'] ?? 0),
            'efficiency_rate' => (float) ($data['efficiency_rate'] ?? 0),
            'total_revenue' => (float) ($data['total_revenue'] ?? 0),
        ];
    }
}

if (!function_exists('generatePickupTrends')) {
    function generatePickupTrends($pickups, $groupBy = 'day') {
        $trends = [];
        
        foreach($pickups as $pickup) {
            $date = $pickup['scheduled_date'];
            
            if($groupBy == 'week') {
                $date = date('Y-W', strtotime($date));
            } elseif($groupBy == 'month') {
                $date = date('Y-m', strtotime($date));
            }
            
            if(!isset($trends[$date])) {
                $trends[$date] = [
                    'date' => $date,
                    'total' => 0,
                    'completed' => 0,
                    'missed' => 0,
                ];
            }
            
            $trends[$date]['total']++;
            
            if($pickup['pickup_status'] == 'Completed') {
                $trends[$date]['completed']++;
            } elseif($pickup['pickup_status'] == 'Missed') {
                $trends[$date]['missed']++;
            }
        }
        
        return array_values($trends);
    }
}