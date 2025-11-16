<?php

namespace App\Controllers\Audio;

use App\Controllers\LoadController;
use App\Libraries\Routing;

use App\Libraries\Resources;

class Audio extends LoadController {
    
    public function list() {
        $filters = [
            'user_id' => $this->currentUser['id'] ?? 0,
            'transcription_id' => $this->payload['transcription_id'] ?? null,
        ];

        $data = $this->audioModel->listAudioFiles($filters, $this->payload['limit'] ?? 10, $this->payload['offset'] ?? 0);

        return Routing::success(formatAudio($data));
    }

    /**
     * View an audio file
     * @param int $id
     * @return array
     */
    public function view() {

        if(empty($this->uniqueId)) {
            return Routing::error('The audio id is required.');
        }

        $payload = ['id' => $this->uniqueId];
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $audioRecord = $this->audioModel->checkExists($payload);
        if(empty($audioRecord)) {
            return Routing::notFound();
        }

        return Routing::success('Audio file view retrieved successfully');
    }

    /**
     * Create an audio file
     * @param array $data
     * @return array
     */
    public function create() {


        // upload the media files if any
        $media = new Resources();
        $media = $media->uploadMedia(
            'transcriptions', 
            $this->payload['transcription_id'], 
            $this->currentUser['id'], 
            $this->payload['file_uploads']
        );

        if(empty($media)) {
            return Routing::error('Failed to upload audio file');
        }

        $reform = [];
        foreach($media as $key => $value) {
            $reform[] = base_url($key);
        }

        return Routing::created(['data' => 'Audio file created successfully', 'record' => $reform]);
    }

    /**
     * Update an audio file
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update() {
        
        if(empty($this->uniqueId)) {
            return Routing::error('The audio id is required.');
        }

        $payload = ['id' => $this->uniqueId];
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $audioRecord = $this->audioModel->checkExists($payload);
        if(empty($audioRecord)) {
            return Routing::notFound();
        }

        return Routing::success('Audio file updated successfully');
    }

    /**
     * Delete an audio file
     * @return array
     */
    public function delete() {
        if(empty($this->uniqueId)) {
            return Routing::error('The audio id is required.');
        }

        $payload = ['id' => $this->uniqueId];
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $audioRecord = $this->audioModel->checkExists($payload);
        if(empty($audioRecord)) {
            return Routing::notFound();
        }

        $data = $this->audioModel->deleteRecord($this->uniqueId);
        if(empty($data)) {
            return Routing::error('Failed to delete audio file record');
        }

        return Routing::success('Audio file deleted successfully');

    }


}