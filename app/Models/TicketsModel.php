<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TicketsModel extends Model {

    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'status', 'type', 'priority', 'subject', 'request_id',
        'description', 'created_at', 'updated_at', 'messages_count'
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
     * List tickets
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array|bool
     */
    public function listTickets($filters = [], $limit = null, $offset = 0) {
        $query = $this->select('tickets.*, users.email, users.name')
            ->join('users', 'users.id = tickets.user_id', 'left')
            ->orderBy('tickets.id', 'DESC')
            ->limit($limit, $offset * $limit);

        foreach($filters as $key => $value) {
            if(!empty($value)) {
                if(is_array($value)) {
                    $query->whereIn("tickets.{$key}", $value);
                } else {
                    $query->where("tickets.{$key}", $value);
                }
            }
        }
        $query->where('tickets.status !=', 'deleted');

        $query->orderBy('tickets.id', 'DESC')
            ->limit($limit, $offset * $limit);

        return $query->get()->getResultArray();
    }

    /**
     * Count tickets
     * @param array $filters
     * @return int
     */
    public function countTickets($filters = []) {
        try {
            return $this->where($filters)
                        ->where('status !=', 'deleted')
                        ->countAllResults();
        } catch(DatabaseException $e) {
            log_message('error', 'Ticket Count Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if a ticket exists
     * @param array $filters
     * @return array|bool
     */
    public function listMessages($filters = []) {
        try {
            return $this->db->table('ticket_messages')->where($filters)->get()->getResultArray();
        } catch(DatabaseException $e) {
            log_message('error', 'Ticket Exists Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if a ticket exists
     * @param array $filters
     * @return array|bool
     */
    public function checkExists($filters = []) {
        try {
            return $this->select('tickets.*, users.email, users.name')
                        ->join('users', 'users.id = tickets.user_id', 'left')
                        ->where($filters)
                        ->where('tickets.status !=', 'deleted')
                        ->first();
        } catch(DatabaseException $e) {
            log_message('error', 'Ticket Exists Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a message for a ticket
     * @param array $data
     * @return int|bool
     */
    public function createMessage($data = []) {
        try {
            $this->db->table('ticket_messages')->insert($data);
            return $this->db->insertID();
        } catch(DatabaseException $e) {
            log_message('error', 'Ticket Message Create Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a ticket
     * @param array $data
     * @return int|bool
     */
    public function createTicket($data = []) {
        try {
            $this->insert($data);
            return $this->insertID();
        } catch(DatabaseException $e) {
            log_message('error', 'Ticket Create Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a ticket
     * @param int $id
     * @param array $data
     * @return int|bool
     */
    public function updateTicket($id, $data = []) {
        try {
            $this->update($id, $data);
            return $this->affectedRows();
        } catch(DatabaseException $e) {
            log_message('error', 'Ticket Update Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a ticket
     * @param int $id
     * @return array|bool
     */
    public function getTicket($id) {
        try {
            return $this->where('id', $id)
                        ->where('status !=', 'deleted')
                        ->first();
        } catch(DatabaseException $e) {
            log_message('error', 'Ticket Get Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all tickets
     * @return array|bool
     */
    public function getAllTickets() {
        try {
            return $this->where('status !=', 'deleted')
                        ->findAll();
        } catch(DatabaseException $e) {
            log_message('error', 'Ticket Get All Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a ticket
     * @param int $id
     * @return int|bool
     */
    public function deleteTicket($id) {
        try {
            $this->delete($id);
            return $this->affectedRows();
        } catch(DatabaseException $e) {
            log_message('error', 'Ticket Delete Error: ' . $e->getMessage());
            return false;
        }
    }
}