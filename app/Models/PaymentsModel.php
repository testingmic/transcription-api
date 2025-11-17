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
        'status', 
        'created_at', 
        'updated_at',
        'transaction_id', 
        'payment_method', 
        'subscription_plan',
        'subscription_month', 
        'subscription_year'
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
    public function createPayment($data = []) {
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
    public function updatePayment($id, $data = []) {
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
    
    
}