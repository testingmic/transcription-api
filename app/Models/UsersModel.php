<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class UsersModel extends Model {

    public $id;

    public $isAdmin = true;
    public $key = "account";
    protected $primaryKey = "id";
    protected $table ;
    protected $altUserTable;
    protected $accessTable;
    protected $teamsTable;
    protected $authTokenTable;
    protected $organizationTable;
    protected $paginateObject;
    protected $allowedFields = [
        "username", "email", "name", "status", "two_factor_setup", "twofactor_secret", "user_type",
        "admin_access", "date_registered", "nationality", "gender", "date_of_birth", "phone",  
        "password", "billing_address", "timezone", "website", "job_title", "description", "skills", 
        "social_links", "language", "rating", "image", "branch_id", "pharmacy_id", "pin_hash",
        "user_device_model", "photo"
    ];
    
    public function __construct() {
        parent::__construct();
        
        $this->table = DbTables::$userTable;
        foreach(DbTables::initTables() as $key) {
            if (property_exists($this, $key)) {
                $this->{$key} = DbTables::${$key};
            }
        }
    }

    /**
     * Find users
     * 
     * @param int|null $limit
     * @param int $offset
     * @param string|null $search
     * @return array
     */
    public function findUsers(?int $limit = null, int $offset = 0, ?string $search = null, ?array $status = ['Active'], ?array $userIds = [], ?array $data = [])
    {
        // get query
        $query = $this->limit($limit, $offset * $limit);

        // search
        if(!empty($search)) {
            $query->groupStart();
            $query->like('phone', $search);
            // search in phone, email, username, full_name
            foreach (['email', 'username', 'firstname', 'lastname', 'role'] as $where) {
                $query->orLike($where, $search);
            }
            $query->groupEnd();
        }

        if(!empty($status)) {
            $status = !is_array($status) ? [$status] : $status;
            $query->whereIn('status', $status);
        }

        if(!empty($userIds)) {
            $query->whereIn('id', $userIds);
        }

        if(!empty($data)) {
            foreach($data as $key => $value) {
                if(is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        $query->orderBy('id', 'DESC');
        $query->limit($limit, $offset);

        return $query->get()->getResultArray();
    }

    /**
     * Get users with filters
     * 
     * @param array $filters
     * @return array
     */
    public function getUsersWithFilters($filters = []) {
        return $this->findUsers(null, 0, $filters['search'] ?? null, $filters['status'] ?? null, $filters['userIds'] ?? null, $filters['data'] ?? []);   
    }

    /**
     * Get new users count
     * 
     * @param string|null $startDate
     * @param string|null $endDate
     * @return int
     */
    public function getNewUsersCount($startDate = null, $endDate = null) {
        $builder = $this->builder();
        
        if ($startDate && $endDate) {
            $builder->where('created_at >=', $startDate)
                   ->where('created_at <=', $endDate);
        } elseif ($startDate) {
            $builder->where('DATE(created_at)', $startDate);
        }

        return $builder->countAllResults();
    }   

    /**
     * Get active users count
     * 
     * @param string|null $startDate
     * @param string|null $endDate
     * @return int
     */
    public function getActiveUsersCount($startDate = null, $endDate = null) {
        $builder = $this->builder();
        
        if ($startDate && $endDate) {
            $builder->where('created_at >=', $startDate)
                   ->where('created_at <=', $endDate);
        } elseif ($startDate) {
            $builder->where('DATE(created_at)', $startDate);
        }

        return $builder->countAllResults();
    }

    /**
     * Global find
     * 
     * @param array $data
     * @return array
     */
    public function globalSearchColumn($column, $data) {
        return $this->db->table($this->table)->select($column)->where($data)->get()->getRowArray();
    }

    /**
     * Search by emails
     * 
     * @param array $emails
     * @return array
     */
    public function getAdminsByEmails() {
        try {
            return $this->db->table($this->table)
                            ->select('firstname, lastname, email, username, password')
                            ->where('admin_access', 1)
                            ->whereIn('status', ['Active'])
                            ->where('permissions LIKE "%write%"')
                            ->get()
                            ->getResultArray();
        } catch(DatabaseException $e) {
            return [];
        }
    }

    /**
     * Global find
     * 
     * @param array $data
     * @return array
     */
    public function globalSearch($data) {
        try {
            return $this->db->table($this->table)->select('*')->where($data)->get()->getRowArray();
        } catch(DatabaseException $e) {
            return [];
        }
    }

    /**
     * Find user by id
     * 
     * @param int $id
     * @return array|null
     */
    public function findById(int $id, array $status = ['Active'], $data = [])
    {
        try {
            $query = $this->where('id', $id)->whereIn('status', $status);

            if(!empty($data)) {
                foreach($data as $key => $value) {
                    $query->where($key, $value);
                }
            }

            return $query->first();
        } catch(DatabaseException $e) {
            return [];
        }
    }

    /**
     * Find user by email
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail($email, array $status = ['Active']) {
        try {
            return $this->where(['email' => $email])
                        ->whereIn('status', $status)
                        ->first();
        } catch(DatabaseException $e) {
            return [];
        }
    }

    /**
     * Get delete request
     * 
     * @param int $user_id
     * @return array|null
     */
    public function getDeleteRequest($user_id, $column = 'user_id') {

        try {
            return $this->db->table('delete_requests')
                            ->where($column, $user_id)
                            ->get()
                            ->getRowArray();
        } catch(DatabaseException $e) {
            return [];
        }

    }

    /**
     * Update a delete request
     * 
     * @param int $user_id
     * @param array $data
     * @return array|null
     */
    public function updateDeleteRequest($user_id, $data) {
        try {
            return $this->db->table('delete_requests')->where('user_id', $user_id)->update($data);
        } catch(DatabaseException $e) {
            return [];
        }
    }

    /**
     * Get all the delete requests
     * 
     * @return array
     */
    public function getDeleteRequests() {

        try {
            return $this->db->table('delete_requests')
                            ->select('delete_requests.*, users.email, users.name')
                            ->join('users', 'users.id = delete_requests.user_id', 'left')
                            ->orderBy('delete_requests.requested_at', 'DESC')
                            ->get()
                            ->getResultArray();
        } catch(DatabaseException $e) {
            return [];
        }

    }

    /**
     * Create a delete request
     * 
     * @param array $data
     * @return array|null
     */
    public function insertDeleteRequest($data) {

        try {
            $this->db->table('delete_requests')->insert($data);
            return $this->db->insertID();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Quick find by username
     * 
     * @param string $username
     * @param array $status
     * 
     * @return array|null
     */
    public function quickFindByLogin($username, array $status = ['Active']) {
        return $this->where(['username' => $username])
                    ->whereIn('status', $status)
                    ->first();
    }

    /**
     * Find user by username
     * 
     * @param string $username
     * @return array|null
     */
    public function findByLogin($username, array $status = ['Active']) {
        try {
            return $this->select("{$this->table}.*, {$this->table}.id as user_id")
                        ->where(["{$this->table}.username" => $username])
                        ->whereIn("{$this->table}.status", stringToArray($status))
                        ->first();
        } catch(DatabaseException $e) {
            return [];
        }
    }

    /**
     * Find user by email or username
     * 
     * @param string $email
     * @param string $username
     * @param array $status
     * 
     * @return array|null
     */
    public function findByEmailOrLogin($email, $username, array $status = ['Active']) {
        try {
            return $this->groupStart()->where(['email' => $email])
                        ->orWhere(['username' => $username])
                        ->groupEnd()
                        ->whereIn('status', $status)
                        ->first();
        } catch(DatabaseException $e) {
            return [];
        }
    }

    /**
     * Create a record
     * 
     * @param array $data
     * 
     * @return bool
     */
    public function createRecord(array $data) {
        try {
            $this->db->table($this->table)->insert($data);
            return $this->db->insertID();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Create an organization record
     * 
     * @param array $data
     * 
     * @return bool
     */
    public function createOrganizationRecord(array $data) {
        try {
            $this->db->table($this->organizationTable)->insert($data);
            return $this->db->insertID();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Get an organization record
     * 
     * @param array $data
     * 
     * @return array|false
     */
    public function getOrganizationRecord(array $data) {
        try {
            return $this->db->table($this->organizationTable)->where($data)->get()->getRowArray();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Get organizations
     * 
     * @return array|false
     */
    public function getOrganizations() {
        try {
            return $this->db->table($this->organizationTable)->get()->getResultArray();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Update a record
     * 
     * @param int $id
     * @param array $data
     * 
     * @return bool
     */
    public function updateRecord(int $id, array $data) {
        try {
            return $this->db->table($this->table)->where(['id' => $id])->update($data);
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Delete alt user
     * 
     * @param array $data
     * 
     * @return bool
     */
    public function deleteAltUser(array $data) {
        try {
            return $this->db->table($this->altUserTable)->where($data)->delete();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Insert alt user
     * 
     * @param array $data
     * 
     * @return bool
     */
    public function insertAltUser(array $data) {
        try {
            return $this->db->table($this->altUserTable)->insert($data);
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Get alt user
     * 
     * @param array $data
     * 
     * @return array|null
     */
    public function getAltUser(array $data) {
        try {
            return $this->db->table($this->altUserTable)->where($data)->get()->getRowArray();
        } catch(DatabaseException $e) {
            return [];
        }
    }

    /**
     * Update record by email
     * 
     * @param string $email
     * @param array $data
     * 
     * @return bool
     */
    public function updateRecordByEmail(string $email, array $data) {
       try {
            return $this->db->table($this->table)->where(['email' => $email])->update($data);
       } catch(DatabaseException $e) {
            return false;
       }
    }

    /**
     * Delete a record
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function deleteRecord(array $data) {
        try {
            return $this->db->table($this->table)->where($data)->delete();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Get comprehensive user analytics
     * 
     * @param array $filters
     * @return array
     */
    public function getUserAnalytics($filters = []) {

        try {
            // Get date range filter if provided
            $startDate = $filters['start_date'] ?? null;
            $endDate = $filters['end_date'] ?? null;
            $period = $filters['period'] ?? '30d';
            
            // Calculate date range based on period
            if (!$startDate && !$endDate) {
                $endDate = date('Y-m-d');
                switch ($period) {
                    case '7d':
                        $startDate = date('Y-m-d', strtotime('-7 days'));
                        break;
                    case '90d':
                        $startDate = date('Y-m-d', strtotime('-90 days'));
                        break;
                    case '1y':
                        $startDate = date('Y-m-d', strtotime('-1 year'));
                        break;
                    case 'all':
                        $startDate = null;
                        break;
                    case '30d':
                    default:
                        $startDate = date('Y-m-d', strtotime('-30 days'));
                        break;
                }
            }

            // Build date filter clause
            $dateFilter = '';
            if ($startDate && $endDate) {
                $dateFilter = "AND created_at BETWEEN '{$startDate}' AND '{$endDate}'";
            } elseif ($startDate) {
                $endDate = date('Y-m-d');
                $dateFilter = "AND created_at >= '{$startDate}' AND created_at <= '{$endDate}'";
            }

            // Get total users
            $getAllUsers = $this->db->table($this->table)->get()->getResultArray();

            // Get total users
            $totalUsers = count($getAllUsers);

            $activeUsers = 0;
            $newUsers = 0;

            // Calculate growth rate (current period vs previous period)
            $previousStartDate = null;
            $previousEndDate = null;
            if ($startDate && $endDate) {
                $daysDiff = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
                $previousEndDate = date('Y-m-d', strtotime($startDate) - 1);
                $previousStartDate = date('Y-m-d', strtotime($previousEndDate) - $daysDiff);
            }

            $previousPeriodUsers = 0;
            
            $statusMapping = [
                'verified' => 'Active',
                'unverified' => 'Inactive',
                'suspended' => 'Suspended',
                'banned' => 'Banned'
            ];

            $userStatusBreakdown = [
                'verified' => 0,
                'unverified' => 0,
                'suspended' => 0,
                'banned' => 0
            ];

            $oneDayAgo = date('Y-m-d', strtotime('-1 day'));
            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
            $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));

            
            $userActivity = [
                'dailyActiveUsers' => 0,
                'weeklyActiveUsers' => 0,
                'monthlyActiveUsers' => 0,
                'averageSessionDuration' => 0 
            ];

            /**
             * @var array $devices
             * @var string $devices['iOS']
             * @var string $devices['Android']
             */
            $devices = ['iOS' => 0, 'Android' => 0, 'Web' => 0];

            // Get active users (logged in within last 30 days)
            foreach($getAllUsers as $user) {

                if(!empty($user['last_login']) && $user['last_login'] >= date('Y-m-d', strtotime('-30 days'))) {
                    $activeUsers++;
                }
                if(strtotime($startDate) >= strtotime($user['created_at']) && strtotime($endDate) <= strtotime($user['created_at'])) {
                    $newUsers++;
                }
                if(strtotime($previousStartDate) >= strtotime($user['created_at']) && strtotime($previousEndDate) <= strtotime($user['created_at'])) {
                    $previousPeriodUsers++;
                }
                foreach($statusMapping as $key => $value) {
                    if($user['status'] == $value) {
                        $userStatusBreakdown[$key]++;
                    }
                }

                if(!empty($user['user_device_model'])) {
                    $devices[$user['user_device_model']]++;
                }

                if(!empty($user['last_login']) && $user['last_login'] >= $oneDayAgo) {
                    $userActivity['dailyActiveUsers']++;
                }
                if(!empty($user['last_login']) && $user['last_login'] >= $sevenDaysAgo) {
                    $userActivity['weeklyActiveUsers']++;
                }
                if(!empty($user['last_login']) && $user['last_login'] >= $thirtyDaysAgo) {
                    $userActivity['monthlyActiveUsers']++;
                }

            }

            // Device distribution (placeholder - would need device tracking)
            $deviceDistribution = [
                [
                    'device' => 'iOS',
                    'count' => $devices['iOS'],
                    'percentage' => $devices['iOS'] > 0 ? round(($devices['iOS'] / $totalUsers) * 100, 2) : 0
                ],
                [
                    'device' => 'Android',
                    'count' => $devices['Android'],
                    'percentage' => $devices['Android'] > 0 ? round(($devices['Android'] / $totalUsers) * 100, 2) : 0
                ]
            ];

            // Get inactive users (no login in last 30 days)
            $inactiveUsers = $totalUsers - $activeUsers;
            
            // Calculate growth rate percentage change
            $percentageChange = $previousPeriodUsers > 0 
                ? round((($newUsers - $previousPeriodUsers) / $previousPeriodUsers) * 100, 2) 
                : 0;

            $growthRate = [
                'currentPeriod' => intval($newUsers),
                'previousPeriod' => intval($previousPeriodUsers),
                'percentageChange' => $percentageChange
            ];

            // Get subscription distribution
            $subscriptionQuery = "
                SELECT 
                    LOWER(COALESCE(subscription_plan, 'free')) as plan,
                    COUNT(*) as count
                FROM users
                GROUP BY subscription_plan
            ";
            $subscriptionData = $this->db->query($subscriptionQuery)->getResultArray();
            
            $subscriptionDistribution = [];
            foreach ($subscriptionData as $sub) {
                $percentage = $totalUsers > 0 ? round(($sub['count'] / $totalUsers) * 100, 2) : 0;
                $subscriptionDistribution[] = [
                    'plan' => strtolower($sub['plan']),
                    'count' => intval($sub['count']),
                    'percentage' => $percentage
                ];
            }

            // Get registration trends (daily for the period)
            $trendsQuery = "
                SELECT 
                    DATE(created_at) as date,
                    COUNT(*) as count
                FROM users
                WHERE 1=1 {$dateFilter}
                GROUP BY DATE(created_at)
                ORDER BY date ASC
            ";
            $registrationTrends = $this->db->query($trendsQuery)->getResultArray();

            // Get engagement metrics
            $avgTranscriptionsQuery = "
                SELECT 
                    CAST(COUNT(t.id) AS FLOAT) / CAST(COUNT(DISTINCT t.user_id) AS FLOAT) as avg
                FROM transcriptions t
            ";
            $avgTranscriptions = $this->db->query($avgTranscriptionsQuery)->getRow()->avg ?? 0;

            $avgTransactionsQuery = "
                SELECT 
                    CAST(COUNT(p.id) AS FLOAT) / CAST(COUNT(DISTINCT p.user_id) AS FLOAT) as avg
                FROM payments p
                WHERE p.status IN ('Success', 'Successful', 'Approved', 'completed')
            ";
            $avgTransactions = $this->db->query($avgTransactionsQuery)->getRow()->avg ?? 0;

            // Get most active users
            $mostActiveQuery = "
                SELECT 
                    u.id as user_id,
                    u.name as name,
                    u.email as email,
                    COUNT(DISTINCT t.id) as transcriptionCount,
                    COUNT(DISTINCT p.id) as transactionCount,
                    u.last_login as lastActive
                FROM users u
                LEFT JOIN transcriptions t ON u.id = t.user_id
                LEFT JOIN payments p ON u.id = p.user_id AND p.status IN ('Success', 'Successful', 'Approved', 'completed')
                GROUP BY u.id
                ORDER BY transcriptionCount DESC, transactionCount DESC
                LIMIT 10
            ";
            $mostActiveUsers = $this->db->query($mostActiveQuery)->getResultArray();

            // Calculate churn and retention (simplified)
            $churnRate = $totalUsers > 0 ? round(($inactiveUsers / $totalUsers) * 100, 2) : 0;
            $retentionRate = 100 - $churnRate;

            $engagementMetrics = [
                'averageTranscriptionsPerUser' => round(floatval($avgTranscriptions), 2),
                'averageTransactionsPerUser' => round(floatval($avgTransactions), 2),
                'mostActiveUsers' => $mostActiveUsers,
                'churnRate' => $churnRate,
                'retentionRate' => $retentionRate
            ];

            // Geographic distribution (if nationality field is populated)
            $geoQuery = "
                SELECT 
                    COALESCE(nationality, 'Unknown') as country,
                    COUNT(*) as count
                FROM users
                WHERE nationality IS NOT NULL AND nationality != ''
                GROUP BY nationality
                ORDER BY count DESC
                LIMIT 10
            ";
            $geoData = $this->db->query($geoQuery)->getResultArray();
            
            $geographicDistribution = [];
            foreach ($geoData as $geo) {
                $percentage = $totalUsers > 0 ? round(($geo['count'] / $totalUsers) * 100, 2) : 0;
                $geographicDistribution[] = [
                    'country' => $geo['country'],
                    'count' => intval($geo['count']),
                    'percentage' => $percentage
                ];
            }

            return [
                'totalUsers' => intval($totalUsers),
                'activeUsers' => intval($activeUsers),
                'newUsers' => intval($newUsers),
                'inactiveUsers' => intval($inactiveUsers),
                'growthRate' => $growthRate,
                'subscriptionDistribution' => $subscriptionDistribution,
                'userActivity' => $userActivity,
                'registrationTrends' => $registrationTrends,
                'engagementMetrics' => $engagementMetrics,
                'geographicDistribution' => $geographicDistribution,
                'deviceDistribution' => $deviceDistribution,
                'userStatusBreakdown' => $userStatusBreakdown
            ];

        } catch (DatabaseException $e) {
            log_message('error', 'User Analytics Error: ' . $e->getMessage());
            return [
                'totalUsers' => 0,
                'activeUsers' => 0,
                'newUsers' => 0,
                'inactiveUsers' => 0,
                'growthRate' => ['currentPeriod' => 0, 'previousPeriod' => 0, 'percentageChange' => 0],
                'subscriptionDistribution' => [],
                'userActivity' => ['dailyActiveUsers' => 0, 'weeklyActiveUsers' => 0, 'monthlyActiveUsers' => 0, 'averageSessionDuration' => 0],
                'registrationTrends' => [],
                'engagementMetrics' => ['averageTranscriptionsPerUser' => 0, 'averageTransactionsPerUser' => 0, 'mostActiveUsers' => [], 'churnRate' => 0, 'retentionRate' => 0],
                'geographicDistribution' => [],
                'deviceDistribution' => [],
                'userStatusBreakdown' => ['verified' => 0, 'unverified' => 0, 'suspended' => 0, 'banned' => 0]
            ];
        }
    }

}
?>
