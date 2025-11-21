<?php

// ==================== FunnelsModel.php ====================
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TranscriptionsModel extends Model {
    
    protected $table = 'transcriptions';
    protected $audioTable = 'audio_files';
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
        $query = $this->db->table("{$this->table} t")
            ->select('t.*, a.audioUrl, a.id AS audio_id')
            ->join("{$this->audioTable} a", 'a.transcription_id = t.id', 'left')
            ->orderBy('t.id', 'DESC')
            ->limit($limit, $offset * $limit);

        foreach($filters as $key => $value) {
            if(!empty($value)) {
                if(is_array($value)) {
                    $query->whereIn("t.{$key}", $value);
                } else {
                    $query->where("t.{$key}", $value);
                }
            }
        }

        $query->orderBy('t.id', 'DESC')
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

    public function countTranscriptions() {
        try {
            return $this->countAllResults();
        } catch(DatabaseException $e) {
            log_message('error', 'Transcription Count Error: ' . $e->getMessage());
            return 0;
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
            $query = $this->db->table("{$this->table} t")
                ->select('t.*, a.audioUrl, a.id AS audio_id')
                ->join("{$this->audioTable} a", 'a.transcription_id = t.id', 'left');
            foreach($filters as $key => $value) {
                $query->where("t.{$key}", $value);
            }
            return $query->get()->getRowArray();
            
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

    /**
     * Get transcription statistics
     * @param string|null $startDate
     * @param string|null $endDate
     * @param int|null $userId Optional user ID filter
     * @return array
     */
    public function getStats($startDate = null, $endDate = null, $userId = null) {
        try {
            $query = $this->db->table($this->table);
            
            // Apply date filters if provided
            if (!empty($startDate)) {
                $query->where('DATE(created_at) >=', $startDate);
            }
            if (!empty($endDate)) {
                $query->where('DATE(created_at) <=', $endDate);
            }
            
            // Apply user filter if provided
            if (!empty($userId)) {
                $query->where('user_id', $userId);
            }
            
            // Get total count
            $total = $query->countAllResults(false);
            
            // Reset query for status counts
            $query = $this->db->table($this->table);
            if (!empty($startDate)) {
                $query->where('DATE(created_at) >=', $startDate);
            }
            if (!empty($endDate)) {
                $query->where('DATE(created_at) <=', $endDate);
            }
            if (!empty($userId)) {
                $query->where('user_id', $userId);
            }
            
            // Get status counts
            $completedQuery = $this->db->table($this->table);
            if (!empty($startDate)) {
                $completedQuery->where('DATE(created_at) >=', $startDate);
            }
            if (!empty($endDate)) {
                $completedQuery->where('DATE(created_at) <=', $endDate);
            }
            if (!empty($userId)) {
                $completedQuery->where('user_id', $userId);
            }
            $completed = $completedQuery->where('status', 'COMPLETED')->countAllResults(false);
            
            $processingQuery = $this->db->table($this->table);
            if (!empty($startDate)) {
                $processingQuery->where('DATE(created_at) >=', $startDate);
            }
            if (!empty($endDate)) {
                $processingQuery->where('DATE(created_at) <=', $endDate);
            }
            if (!empty($userId)) {
                $processingQuery->where('user_id', $userId);
            }
            $processing = $processingQuery->where('status', 'PROCESSING')->countAllResults(false);
            
            $failedQuery = $this->db->table($this->table);
            if (!empty($startDate)) {
                $failedQuery->where('DATE(created_at) >=', $startDate);
            }
            if (!empty($endDate)) {
                $failedQuery->where('DATE(created_at) <=', $endDate);
            }
            if (!empty($userId)) {
                $failedQuery->where('user_id', $userId);
            }
            $failed = $failedQuery->where('status', 'FAILED')->countAllResults(false);
            
            // Get duration statistics
            $query = $this->db->table($this->table)
                ->select('SUM(duration) as totalDuration, AVG(duration) as averageDuration')
                ->where('duration >', 0);
            
            if (!empty($startDate)) {
                $query->where('DATE(created_at) >=', $startDate);
            }
            if (!empty($endDate)) {
                $query->where('DATE(created_at) <=', $endDate);
            }
            if (!empty($userId)) {
                $query->where('user_id', $userId);
            }
            
            $durationStats = $query->get()->getRowArray();
            $totalDuration = $durationStats['totalDuration'] ?? 0;
            $averageDuration = $durationStats['averageDuration'] ?? 0;
            
            // Get statistics by date
            $query = $this->db->table($this->table)
                ->select('DATE(created_at) as date, COUNT(*) as count, SUM(duration) as duration')
                ->groupBy('DATE(created_at)')
                ->orderBy('date', 'ASC');
            
            if (!empty($startDate)) {
                $query->where('DATE(created_at) >=', $startDate);
            }
            if (!empty($endDate)) {
                $query->where('DATE(created_at) <=', $endDate);
            }
            if (!empty($userId)) {
                $query->where('user_id', $userId);
            }
            
            $byDate = $query->get()->getResultArray();
            
            // Format byDate array
            $formattedByDate = [];
            foreach ($byDate as $row) {
                $formattedByDate[] = [
                    'date' => $row['date'] ?? '',
                    'count' => (int)($row['count'] ?? 0),
                    'duration' => (int)($row['duration'] ?? 0)
                ];
            }
            
            // If no date data, return empty array instead of placeholder
            if (empty($formattedByDate)) {
                $formattedByDate = [];
            }
            
            return [
                'total' => (int)$total,
                'completed' => (int)$completed,
                'processing' => (int)$processing,
                'failed' => (int)$failed,
                'totalDuration' => (int)$totalDuration,
                'averageDuration' => round((float)$averageDuration, 2),
                'byDate' => $formattedByDate
            ];
            
        } catch(DatabaseException $e) {
            log_message('error', 'Transcription Stats Error: ' . $e->getMessage());
            return [
                'total' => 0,
                'completed' => 0,
                'processing' => 0,
                'failed' => 0,
                'totalDuration' => 0,
                'averageDuration' => 0,
                'byDate' => []
            ];
        }
    }
}

?>