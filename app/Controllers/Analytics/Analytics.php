<?php 
/**
 * File: app/Controllers/Analytics/Analytics.php
 * Analytics and Insights Controller
 */
namespace App\Controllers\Analytics;

use App\Controllers\LoadController;
use App\Libraries\Routing;
use App\Models\AnalyticsModel;

class Analytics extends LoadController {

    protected $analyticsModel;

    public function __construct() {
        parent::__construct();
        $this->analyticsModel = new AnalyticsModel();
    }

    public function dashboard() {
        $userType = $this->currentUser['user_type'] ?? 'admin';
        $userId = $this->currentUser['id'] ?? null;
        $data = [];

        switch($userType) {
            case 'contractor':
                $data = $this->analyticsModel->getContractorDashboard($this->currentUser['contractor_id']);
                break;
            case 'assembly':
                $data = $this->analyticsModel->getAssemblyDashboard($this->currentUser['assembly_id']);
                break;
            case 'driver':
                $data = $this->analyticsModel->getDriverDashboard($this->currentUser['driver_id']);
                break;
            case 'household':
                $household = $this->analyticsModel->getHouseholdByUserId($userId);
                $data = $this->analyticsModel->getHouseholdDashboard($household['id'] ?? null);
                break;
            default:
                $data = $this->analyticsModel->getAdminDashboard();
        }

        return Routing::success($data);
    }

    public function pickups() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'jurisdiction_id' => $this->payload['jurisdiction_id'] ?? null,
            'driver_id' => $this->payload['driver_id'] ?? null,
            'date_from' => $this->payload['date_from'] ?? date('Y-m-01'),
            'date_to' => $this->payload['date_to'] ?? date('Y-m-t'),
            'group_by' => $this->payload['group_by'] ?? 'day'
        ];

        if(!empty($this->currentUser) && $this->currentUser['user_type'] == 'contractor') {
            $filters['contractor_id'] = $this->currentUser['contractor_id'];
        }

        $analytics = $this->analyticsModel->getPickupAnalytics($filters);
        return Routing::success($analytics);
    }

    public function revenue() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'jurisdiction_id' => $this->payload['jurisdiction_id'] ?? null,
            'date_from' => $this->payload['date_from'] ?? date('Y-m-01'),
            'date_to' => $this->payload['date_to'] ?? date('Y-m-t'),
            'group_by' => $this->payload['group_by'] ?? 'day'
        ];

        if(!empty($this->currentUser) && $this->currentUser['user_type'] == 'contractor') {
            $filters['contractor_id'] = $this->currentUser['contractor_id'];
        }

        $analytics = $this->analyticsModel->getRevenueAnalytics($filters);
        return Routing::success($analytics);
    }

    public function performanceTrends() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'driver_id' => $this->payload['driver_id'] ?? null,
            'jurisdiction_id' => $this->payload['jurisdiction_id'] ?? null,
            'period' => $this->payload['period'] ?? 'month'
        ];

        if(!empty($this->currentUser) && $this->currentUser['user_type'] == 'contractor') {
            $filters['contractor_id'] = $this->currentUser['contractor_id'];
        }

        $trends = $this->analyticsModel->getPerformanceTrends($filters);
        return Routing::success($trends);
    }

    public function geographicDistribution() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'jurisdiction_id' => $this->payload['jurisdiction_id'] ?? null
        ];

        $distribution = $this->analyticsModel->getGeographicDistribution($filters);
        return Routing::success($distribution);
    }

    public function efficiency() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'driver_id' => $this->payload['driver_id'] ?? null,
            'date_from' => $this->payload['date_from'] ?? date('Y-m-01'),
            'date_to' => $this->payload['date_to'] ?? date('Y-m-t')
        ];

        if(!empty($this->currentUser) && $this->currentUser['user_type'] == 'contractor') {
            $filters['contractor_id'] = $this->currentUser['contractor_id'];
        }

        $metrics = $this->analyticsModel->getEfficiencyMetrics($filters);
        return Routing::success($metrics);
    }

    public function comparativeAnalysis() {
        $compareBy = $this->payload['compare_by'] ?? 'contractor';
        $metric = $this->payload['metric'] ?? 'pickups';
        $period = $this->payload['period'] ?? 'month';

        $analysis = $this->analyticsModel->getComparativeAnalysis($compareBy, $metric, $period);
        return Routing::success($analysis);
    }

    public function timePatterns() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'jurisdiction_id' => $this->payload['jurisdiction_id'] ?? null,
            'analysis_type' => $this->payload['analysis_type'] ?? 'hourly'
        ];

        $patterns = $this->analyticsModel->getTimePatterns($filters);
        return Routing::success($patterns);
    }

    public function growth() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'jurisdiction_id' => $this->payload['jurisdiction_id'] ?? null,
            'metric' => $this->payload['metric'] ?? 'households',
            'period' => $this->payload['period'] ?? 'year'
        ];

        $growth = $this->analyticsModel->getGrowthMetrics($filters);
        return Routing::success($growth);
    }

    public function retention() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'jurisdiction_id' => $this->payload['jurisdiction_id'] ?? null,
            'period' => $this->payload['period'] ?? 'year'
        ];

        if(!empty($this->currentUser) && $this->currentUser['user_type'] == 'contractor') {
            $filters['contractor_id'] = $this->currentUser['contractor_id'];
        }

        $retention = $this->analyticsModel->getRetentionAnalysis($filters);
        return Routing::success($retention);
    }

    public function predictions() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'prediction_type' => $this->payload['prediction_type'] ?? 'demand',
            'forecast_days' => $this->payload['forecast_days'] ?? 30
        ];

        $predictions = $this->analyticsModel->getPredictiveAnalytics($filters);
        return Routing::success($predictions);
    }

    public function satisfaction() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'jurisdiction_id' => $this->payload['jurisdiction_id'] ?? null,
            'date_from' => $this->payload['date_from'] ?? date('Y-m-01'),
            'date_to' => $this->payload['date_to'] ?? date('Y-m-t')
        ];

        if(!empty($this->currentUser) && $this->currentUser['user_type'] == 'contractor') {
            $filters['contractor_id'] = $this->currentUser['contractor_id'];
        }

        $satisfaction = $this->analyticsModel->getSatisfactionMetrics($filters);
        return Routing::success($satisfaction);
    }

    public function operational() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'date_from' => $this->payload['date_from'] ?? date('Y-m-01'),
            'date_to' => $this->payload['date_to'] ?? date('Y-m-t')
        ];

        if(!empty($this->currentUser) && $this->currentUser['user_type'] == 'contractor') {
            $filters['contractor_id'] = $this->currentUser['contractor_id'];
        }

        $operational = $this->analyticsModel->getOperationalMetrics($filters);
        return Routing::success($operational);
    }

    public function financial() {
        $filters = [
            'contractor_id' => $this->payload['contractor_id'] ?? null,
            'jurisdiction_id' => $this->payload['jurisdiction_id'] ?? null,
            'date_from' => $this->payload['date_from'] ?? date('Y-m-01'),
            'date_to' => $this->payload['date_to'] ?? date('Y-m-t')
        ];

        if(!empty($this->currentUser) && $this->currentUser['user_type'] == 'contractor') {
            $filters['contractor_id'] = $this->currentUser['contractor_id'];
        }

        $financial = $this->analyticsModel->getFinancialOverview($filters);
        return Routing::success($financial);
    }

    public function realtime() {
        $type = $this->payload['type'] ?? 'overview';
        $stats = [];

        switch($type) {
            case 'overview':
                $stats = $this->analyticsModel->getRealtimeOverview();
                break;
            case 'pickups':
                $stats = $this->analyticsModel->getRealtimePickups();
                break;
            case 'drivers':
                $stats = $this->analyticsModel->getRealtimeDrivers();
                break;
            case 'alerts':
                $stats = $this->analyticsModel->getRealtimeAlerts();
                break;
        }

        return Routing::success($stats);
    }

    public function export() {
        $analyticsType = $this->payload['analytics_type'];
        $filters = $this->payload['filters'] ?? [];
        $format = $this->payload['format'] ?? 'excel';

        $export = $this->analyticsModel->exportAnalytics($analyticsType, $filters, $format);
        if(!$export) return Routing::error('Failed to export analytics');

        return response()->download($export['path'], $export['filename']);
    }
}