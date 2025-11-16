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
        "social_links", "language", "rating", "image", "branch_id", "pharmacy_id", "pin_hash"
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
            foreach (['email', 'username', 'firstname', 'lastname', 'user_type'] as $where) {
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

}
?>
