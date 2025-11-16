<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class AudioModel extends Model {
    protected $table = 'audio_files';
    protected $primaryKey = 'id';
    protected $allowedFields = ['transcription_id', 'audioUrl', 'mimeType', 'size', 'user_id'];

    /**
     * List audio files
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array|bool
     */
    public function listAudioFiles($filters = [], $limit = null, $offset = 0) {
        $query = $this->select('audio_files.*')
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
     * Create an audio file
     * @param array $data
     * @return int|bool
     */
    public function createRecord($data = []) {
        try {
            $this->insert($data);
            return $this->insertID();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Update an audio file
     * @param int $id
     * @param array $data
     * @return int|bool
     */
    public function updateRecord($id, $data = []) {
        try {
            $this->update($id, $data);
            return $this->affectedRows();
        } catch(DatabaseException $e) {
            return false;
        }
    }

    /**
     * Get an audio file
     * @param int $id
     * @return array|bool
     */
    public function getRecord($id) {
        return $this->find($id);
    }

    /**
     * Get multiple audio files
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array|bool
     */
    public function getRecords($filters = [], $limit = null, $offset = 0) {
        return $this->listAudioFiles($filters, $limit, $offset);
    }

    /**
     * Delete an audio file
     * @param int $id
     * @return int|bool
     */
    public function deleteRecord($id) {
        return $this->delete($id);
    }

    /**
     * Check if an audio file exists
     * @param array $filters
     * @return array|bool
     */
    public function checkExists($filters = []) {
        return $this->where($filters)->get()->getRowArray();
    }

}