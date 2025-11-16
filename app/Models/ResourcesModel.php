<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ResourcesModel extends Model
{
    protected $table = 'audio_files';
    protected $primaryKey = 'id';
    protected $allowedFields = ['size', 'transcription_id', 'user_id', 'thumbnails', 'audioUrl', 'mimeType'];

    public function __construct() {
        parent::__construct();
        
        foreach(DbTables::initTables() as $key) {
            if (property_exists($this, $key)) {
                $this->{$key} = DbTables::${$key};
            }
        }
    }

    /**
     * Get a media record
     * @param int $mediaId
     * 
     * @return array
     */
    public function getMediaRecord($mediaId) {
        return $this->find($mediaId);
    }

    /**
     * Get a media record by record id
     * @param string $recordId
     * 
     * @return array
     */
    public function getMediaRecordByRecordId($recordId) {
        return $this->where('transcription_id', $recordId)->findAll();
    }

    /**
     * Get a media record by record id and section
     * @param string $recordId
     * @param string $section
     * 
     * @return array
     */
    public function getMediaRecordByRecordIdAndSection($recordId, $section) {
        return $this->where('transcription_id', $recordId)->where('section', $section)->findAll();
    }

    /**
     * Delete a media record
     * @param int $mediaId
     * 
     * @return array
     */
    public function deleteMediaRecord($mediaId) {
        return $this->delete($mediaId);
    }

    /**
     * Create a media record
     * @param array $uploadedList
     * @param string $section
     * @param int $recordId
     * @param int $userId
     * 
     * @return array
     */
    public function createMediaRecord($uploadedList, $transcriptionId, $userId) {

        try {

            $data = [
                'user_id' => $userId,
                'size' => $uploadedList['size'],
                'audioUrl' => $uploadedList['audioUrl'],
                'transcription_id' => $transcriptionId,
                'mimeType' => $uploadedList['mimeType'],
                'thumbnails' => $uploadedList['thumbnails'] ?? '',
            ];
            $this->insert($data);

            return $this->getInsertID();
        } catch (DatabaseException $e) {
            return $e->getMessage();
        }
    }
}