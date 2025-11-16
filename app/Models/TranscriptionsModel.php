<?php

// ==================== FunnelsModel.php ====================
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TranscriptionsModel extends Model {
    
    protected $table = 'transcriptions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'transcription', 'summary', 'keywords', 'tags', 'language',
        'categories', 'status', 'created_at', 'updated_at', 'user_id', 'metadata',
        'duration', 'fileSize', 
    ];

    /**
     * List transcriptions
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function listTranscriptions($filters = [], $limit = null, $offset = 0) {
        $query = $this->select('transcriptions.*')
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
     * Create a transcription
     * @param array $data
     * @return int|bool
     */
    public function createRecord($data = []) {
        try {
            $this->insert($data);
            return $this->insertID();
        } catch(DatabaseException $e) {
            log_message('error', 'Transcription Creation Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a transcription
     * @param int $id
     * @param array $data
     * @return int|bool
     */
    public function updateRecord($id, $data = []) {
        try {
            $this->update($id, $data);
            return $this->affectedRows();
        } catch(DatabaseException $e) {
            log_message('error', 'Transcription Update Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a transcription
     * @param int $id
     * @return int|bool
     */
    public function deleteRecord($id) {
        try {
            $this->delete($id);
            return $this->affectedRows();
        } catch(DatabaseException $e) {
            log_message('error', 'Transcription Deletion Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a transcription
     * @param int $id
     * @return array|bool
     */
    public function checkExists($filters = []) {
        try {
            $query = $this->select('*')
                ->where($filters)
                ->get();
            return $query->getRowArray();
        } catch(DatabaseException $e) {
            log_message('error', 'Transcription Exists Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a transcription
     * @param int $id
     * @return array|bool
     */
    public function getRecord($id) {
        try {
            return $this->find($id);
        } catch(DatabaseException $e) {
            log_message('error', 'Transcription Retrieval Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get multiple transcriptions
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array|bool
     */
    public function getRecords($filters = [], $limit = null, $offset = 0) {
        try {
            return $this->listTranscriptions($filters, $limit, $offset);
        } catch(DatabaseException $e) {
            log_message('error', 'Transcriptions Retrieval Error: ' . $e->getMessage());
            return false;
        }
    }
}

?>