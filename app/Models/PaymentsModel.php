<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class PaymentsModel extends Model {

    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',  
        'amount', 
        'amount_ghs',
        'status',
        'created_at', 
        'updated_at',
        'reference',
        'plan_id',
        'plan_name',
        'last4',
        'transaction_id',
        'payment_bank',
        'customer_id',
        'subscription_id',
        'payment_method',  
    ];

    public function __construct() {
        parent::__construct();
        
        foreach(DbTables::initTables() as $key) {
            if (property_exists($this, $key)) {
                $this->{$key} = DbTables::${$key};
            }
        }
    }

    /**
     * List payments
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array|bool
     */
    public function listPayments($filters = [], $limit = null, $offset = 0) {
        $query = $this->select('payments.*')
            ->orderBy('id', 'DESC')
            ->limit($limit, $offset * $limit);

        foreach($filters as $key => $value) {
            if(!empty($value)) {
                if(is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        $query->orderBy('id', 'DESC')
            ->limit($limit, $offset * $limit);

        return $query->get()->getResultArray();
    }

    /**
     * Get a payment
     * @param int $id
     * @return array|bool
     */
    public function getPayment($id) {
        try {
            return $this->find($id);
        } catch(DatabaseException $e) {
            log_message('error', 'Payment Get Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a payment
     * @param array $data
     * @return int|bool
     */
    public function createRecord($data = []) {
        try {
            $this->insert($data);
            return $this->insertID();
        } catch(DatabaseException $e) {
            log_message('error', 'Payment Create Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a payment
     * @param int $id
     * @param array $data
     * @return int|bool
     */
    public function updateRecord($id, $data = []) {
        try {
            $this->update($id, $data);
            return $this->affectedRows();
        } catch(DatabaseException $e) {
            log_message('error', 'Payment Update Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if a payment exists
     * @param array $filters
     * @return array|bool
     */
    public function checkExists($filters = []) {
        try {
            return $this->where($filters)->first();
        } catch(DatabaseException $e) {
            log_message('error', 'Payment Exists Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get revenue analytics data
     * @param array $filters
     * @return array
     */
    public function getRevenueAnalytics($filters = []) {
        try {
            $db = \Config\Database::connect();
            
            // Get date range filter if provided
            $startDate = $filters['start_date'] ?? null;
            $endDate = $filters['end_date'] ?? null;
            
            // Build base query for successful payments only
            $whereClause = "WHERE p.status IN ('Success', 'Successful', 'Approved', 'completed')";
            if ($startDate) {
                $whereClause .= " AND p.created_at >= '{$startDate}'";
            }
            if ($endDate) {
                $whereClause .= " AND p.created_at <= '{$endDate}'";
            }

            // Get total revenue and transaction count
            $summaryQuery = "
                SELECT 
                    COALESCE(SUM(amount_ghs), 0) as totalRevenue,
                    COUNT(*) as totalTransactions,
                    COALESCE(AVG(amount_ghs), 0) as averageTransactionValue
                FROM payments p
                {$whereClause}
            ";
            $summary = $db->query($summaryQuery)->getRowArray();

            // Get revenue by plan
            $planQuery = "
                SELECT 
                    UPPER(COALESCE(plan_name, 'FREE')) as plan,
                    COALESCE(SUM(amount_ghs), 0) as revenue,
                    COUNT(*) as transactions
                FROM payments p
                {$whereClause}
                GROUP BY plan_name
                ORDER BY revenue DESC
            ";
            $revenueByPlan = $db->query($planQuery)->getResultArray();

            // Calculate percentages for revenue by plan
            $totalRevenue = $summary['totalRevenue'];
            foreach ($revenueByPlan as &$plan) {
                $plan['percentage'] = $totalRevenue > 0 ? round(($plan['revenue'] / $totalRevenue) * 100, 2) : 0;
            }

            // Get revenue by period (YYYY-MM)
            $periodQuery = "
                SELECT 
                    strftime('%Y-%m', created_at) as period,
                    COALESCE(SUM(amount_ghs), 0) as revenue,
                    COUNT(*) as transactions
                FROM payments p
                {$whereClause}
                GROUP BY strftime('%Y-%m', created_at)
                ORDER BY period ASC
            ";
            $revenueByPeriod = $db->query($periodQuery)->getResultArray();

            // Get revenue by month (human-readable)
            $monthQuery = "
                SELECT 
                    strftime('%Y-%m', created_at) as period,
                    COALESCE(SUM(amount_ghs), 0) as revenue,
                    COUNT(*) as transactions
                FROM payments p
                {$whereClause}
                GROUP BY strftime('%Y-%m', created_at)
                ORDER BY period ASC
            ";
            $revenueByMonthData = $db->query($monthQuery)->getResultArray();
            
            // Format month names
            $revenueByMonth = array_map(function($item) {
                $date = \DateTime::createFromFormat('Y-m', $item['period']);
                $item['month'] = $date ? $date->format('F Y') : $item['period'];
                unset($item['period']);
                return $item;
            }, $revenueByMonthData);

            // Get revenue by day (last 30 days or filtered range)
            $dayQuery = "
                SELECT 
                    DATE(created_at) as date,
                    COALESCE(SUM(amount_ghs), 0) as revenue,
                    COUNT(*) as transactions
                FROM payments p
                {$whereClause}
                GROUP BY DATE(created_at)
                ORDER BY date ASC
                LIMIT 30
            ";
            $revenueByDay = $db->query($dayQuery)->getResultArray();

            // Get top plans
            $topPlans = $revenueByPlan; // Already sorted by revenue DESC

            // Calculate growth rate (current month vs previous month)
            $growthQuery = "
                SELECT 
                    strftime('%Y-%m', created_at) as period,
                    COALESCE(SUM(amount_ghs), 0) as revenue
                FROM payments p
                WHERE status IN ('Success', 'Successful', 'Approved', 'completed')
                GROUP BY strftime('%Y-%m', created_at)
                ORDER BY period DESC
                LIMIT 2
            ";
            $growthData = $db->query($growthQuery)->getResultArray();
            
            $currentPeriod = isset($growthData[0]) ? floatval($growthData[0]['revenue']) : 0;
            $previousPeriod = isset($growthData[1]) ? floatval($growthData[1]['revenue']) : 0;
            $percentageChange = $previousPeriod > 0 
                ? round((($currentPeriod - $previousPeriod) / $previousPeriod) * 100, 2) 
                : 0;

            $growthRate = [
                'currentPeriod' => $currentPeriod,
                'previousPeriod' => $previousPeriod,
                'percentageChange' => $percentageChange
            ];

            // Get recent transactions with user details
            $recentQuery = "
                SELECT 
                    p.id,
                    p.user_id,
                    u.name as user_name,
                    u.email as user_email,
                    UPPER(COALESCE(p.plan_name, 'FREE')) as plan,
                    COALESCE(p.amount, 0) as amount,
                    COALESCE(p.amount_ghs, 0) as amount_ghs,
                    LOWER(p.status) as status,
                    p.created_at
                FROM payments p
                LEFT JOIN users u ON p.user_id = u.id
                {$whereClause}
                ORDER BY p.created_at DESC
                LIMIT 10
            ";
            $recentTransactions = $db->query($recentQuery)->getResultArray();

            return [
                'totalRevenue' => floatval($summary['totalRevenue']),
                'totalTransactions' => intval($summary['totalTransactions']),
                'averageTransactionValue' => round(floatval($summary['averageTransactionValue']), 2),
                'revenueByPlan' => $revenueByPlan,
                'revenueByPeriod' => $revenueByPeriod,
                'revenueByMonth' => $revenueByMonth,
                'revenueByDay' => $revenueByDay,
                'topPlans' => $topPlans,
                'growthRate' => $growthRate,
                'recentTransactions' => $recentTransactions
            ];

        } catch(DatabaseException $e) {
            log_message('error', 'Revenue Analytics Error: ' . $e->getMessage());
            return [
                'totalRevenue' => 0,
                'totalTransactions' => 0,
                'averageTransactionValue' => 0,
                'revenueByPlan' => [],
                'revenueByPeriod' => [],
                'revenueByMonth' => [],
                'revenueByDay' => [],
                'topPlans' => [],
                'growthRate' => [
                    'currentPeriod' => 0,
                    'previousPeriod' => 0,
                    'percentageChange' => 0
                ],
                'recentTransactions' => []
            ];
        }
    }
    
    
}