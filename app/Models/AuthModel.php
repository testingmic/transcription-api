<?php 

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DbTables;
use CodeIgniter\Database\Exceptions\DatabaseException;

class AuthModel extends Model {

    protected $table;
    public $authTokenTable;
    protected $primaryKey = "idusertokenauth";
    protected $allowedFields = ["username", "description", "password", "date_created", "date_expired", "system_token", "hash_algo"];

    public function __construct() {
        parent::__construct();
        
        $this->table = DbTables::$authTokenTable;
        foreach(DbTables::initTables() as $key) {
            if (property_exists($this, $key)) {
                $this->{$key} = DbTables::${$key};
            }
        }
    }

    public function findOne($token) {

    }

    /**
     * Insert the user token hash
     * 
     * @param string $table
     * @param array $data
     * @return bool
     */
    public function insertToken($data) {
        try {
            $this->db->table($this->authTokenTable)->insert($data);
            // return the insert id
            return $this->db->insertID();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Find the record by username
     * 
     * @param string $username
     * @return array
     */
    public function findRecordByLogin($username) {
        try {
            return $this->db->table($this->authTokenTable)->select('username, hash_algo, password, date_expired, description')->where([
                'username' => $username
            ])->groupStart()
                ->where('date_expired', null)
                ->orWhere('date_expired >', date('Y-m-d H:i:s', strtotime('+24 hours')))
            ->groupEnd()
            ->get()->getRowArray();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Get the record by token
     * 
     * @param string $token
     * @return array
     */
    public function findRecordByToken($token) {
        try {
            return $this->db->table($this->authTokenTable)->select('username, hash_algo, date_expired, description')->where([
                'password' => $token
            ])->groupStart()
                ->where('date_expired', null)
                ->orWhere('date_expired >', date('Y-m-d H:i:s'))
            ->groupEnd()
            ->get()->getRowArray();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Find the user by md5 email
     * 
     * @param string $email
     * @return array
     */
    public function findByMd5Email($email) {
        try {
            return $this->db->table($this->table)->select('*')->where('username', md5($email))->get()->getRowArray();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Delete the user token hash by username
     * 
     * @param string $username
     * @return bool
     */
    public function deleteByLogin($username) {
        try {
            $this->db->table($this->table)->delete(['username' => $username]);
        } catch(DatabaseException $e) {
            return false;
        }
    }
}
?>