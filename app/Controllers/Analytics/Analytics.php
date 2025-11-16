<?php 
/**
 * File: app/Controllers/Analytics/Analytics.php
 * Analytics and Insights Controller
 */
namespace App\Controllers\Analytics;

use App\Controllers\LoadController;
use App\Libraries\Routing;

class Analytics extends LoadController {

    public function dashboard() {
        $userType = $this->currentUser['user_type'] ?? 'admin';
        $userId = $this->currentUser['id'] ?? null;
        $data = [];

        return Routing::success($data);
    }

}