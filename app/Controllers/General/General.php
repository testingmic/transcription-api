<?php 

namespace App\Controllers\General;

use App\Controllers\LoadController;
use App\Libraries\Routing;

class General extends LoadController {

    public function utilities() {
        $result = [];
        return Routing::success($result);
    }

    /**
     * Get the health of the server
     * 
     * @return array
     */
    public function health() {
        return Routing::success([
            'status' => 'ok'
        ]);
    }

    /**
     * Log an event
     * 
     * @return array
     */
    public function event() {
        return Routing::success([
            'status' => 'event logged successfully'
        ]);
    }

    /**
     * Get admin dashboard statistics
     * 
     * @return array
     */
    public function stats() {
        try {
            $db = \Config\Database::connect();

            // Get total users
            $totalUsers = $this->usersModel->countAllResults();

            // Get total transcriptions
            $totalTranscriptions = $this->transcriptionsModel->countAllResults();

            // Get total transactions (successful only)
            $totalTransactionsQuery = "
                SELECT COUNT(*) as count
                FROM payments
                WHERE status IN ('Success', 'Successful', 'Approved', 'completed')
            ";
            $totalTransactions = $db->query($totalTransactionsQuery)->getRow()->count;

            // Get total revenue (successful payments only)
            $totalRevenueQuery = "
                SELECT COALESCE(SUM(amount_ghs), 0) as total
                FROM payments
                WHERE status IN ('Success', 'Successful', 'Approved', 'completed')
            ";
            $totalRevenue = floatval($db->query($totalRevenueQuery)->getRow()->total);

            // Get active subscriptions (non-Free plans with valid expiry)
            $activeSubscriptionsQuery = "
                SELECT COUNT(*) as count
                FROM users
                WHERE subscription_plan != 'Free' 
                AND subscription_plan IS NOT NULL
                AND (subscription_expires_at IS NULL OR subscription_expires_at > datetime('now'))
            ";
            $activeSubscriptions = $db->query($activeSubscriptionsQuery)->getRow()->count;

            // Get recent activity (last 10 activities)
            $recentActivity = [];

            // Get recent user registrations
            $recentUsersQuery = "
                SELECT 'user_registration' as type, 
                       'New user registered: ' || name as description,
                       created_at as timestamp
                FROM users
                ORDER BY created_at DESC
                LIMIT 5
            ";
            $recentUsers = $db->query($recentUsersQuery)->getResultArray();

            // Get recent transactions
            $recentTransactionsQuery = "
                SELECT 'transaction' as type,
                       'Payment received: GHS ' || CAST(amount_ghs AS TEXT) as description,
                       created_at as timestamp
                FROM payments
                WHERE status IN ('Success', 'Successful', 'Approved', 'completed')
                ORDER BY created_at DESC
                LIMIT 5
            ";
            $recentTransactions = $db->query($recentTransactionsQuery)->getResultArray();

            // Merge and sort recent activities
            $recentActivity = array_merge($recentUsers, $recentTransactions);
            usort($recentActivity, function($a, $b) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
            });
            $recentActivity = array_slice($recentActivity, 0, 10);

            return Routing::success([
                'totalUsers' => intval($totalUsers),
                'totalTranscriptions' => intval($totalTranscriptions),
                'totalTransactions' => intval($totalTransactions),
                'totalRevenue' => $totalRevenue,
                'activeSubscriptions' => intval($activeSubscriptions),
                'recentActivity' => $recentActivity
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Admin Stats Error: ' . $e->getMessage());
            return Routing::error('Failed to retrieve admin statistics');
        }
    }

    /**
     * Get all the endpoints for the current user
     * 
     * @return array
     */
    public function endpoints() {

        // Get all the methods for the current user
        $baseDir = APPPATH . 'Libraries/Validation';

        // Recursive function to scan directories
        function scanDirectory($dir, &$results) {
            $files = scandir($dir);

            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $path = $dir . DIRECTORY_SEPARATOR . $file;

                if (is_dir($path)) {
                    scanDirectory($path, $results);
                } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                    $results[] = $path;
                }
            }

        }

        // Scan the base directory for PHP files
        $files = [];
        scanDirectory($baseDir, $files);

        $endpoints = [];

        // Loop through each file and load the class
        foreach ($files as $file) {
            // Extract the class name from the file path
            $className = pathinfo($file, PATHINFO_FILENAME);

            // Assume namespace follows folder structure (e.g., App\Controllers\Subfolder\ClassName)
            $fullClassName = "App\\Libraries\\Validation\\{$className}";

            if (in_array($className, ['GeneralValidation'])) {
                continue;
            }

            $initObject = new $fullClassName();

            $clean = strtolower(str_ireplace('Validation', '', $className));

            foreach($initObject->routes as $key => $value) {
                $endpoints[$clean]["/api/{$clean}/{$key}"] = $value;
            }
        }

        return Routing::success($endpoints, 'Endpoints listed successfully');
    }

}