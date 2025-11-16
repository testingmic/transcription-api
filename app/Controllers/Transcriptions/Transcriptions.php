<?php

namespace App\Controllers\Transcriptions;

use App\Controllers\LoadController;
use App\Libraries\Routing;
use App\Libraries\OpenAI;

class Transcriptions extends LoadController {

    /**
     * List transcriptions
     * 
     * @return array
     */
    public function list() {
        
        $filters = [
            'user_id' => $this->currentUser['id'] ?? 0,
            'status' => $this->payload['status'] ?? null,
            'title' => $this->payload['title'] ?? null,
            'keywords' => $this->payload['keywords'] ?? null,
            'language' => $this->payload['language'] ?? null,
        ];

        $data = $this->transcriptionsModel->listTranscriptions($filters, $this->payload['limit'] ?? 10, $this->payload['offset'] ?? 0);

        return Routing::success(formatTranscription($data));
    }

    /**
     * View a transcription
     * 
     * @return array
     */
    public function view() {

        if(empty($this->uniqueId)) {
            return Routing::error('Transcription ID is required');
        }

        $payload = ['id' => $this->uniqueId];
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $checkExits = $this->transcriptionsModel->checkExists($payload);
        if(empty($checkExits)) {
            return Routing::error('Transcription not found');
        }

        return Routing::success(formatTranscription([$checkExits])[0]);

    }

    /**
     * Create a transcription
     * 
     * @return array
     */
    public function create() {

        // check if the transcription already exists
        $checkExits = $this->transcriptionsModel->checkExists([
            'user_id' => $this->currentUser['id'] ?? 0,
            'fileSize' => $this->payload['fileSize'], 
            'transcription' => $this->payload['text']
        ]);
        if(!empty($checkExits)) {
            return Routing::created([
                'data' => 'There is already a transcription with the same file size and text. Please use the existing transcription.',
                'record' => $checkExits
            ]);
        }

        // create the transcription
        $data = [
            'user_id' => $this->currentUser['id'] ?? 0,
            'title' => $this->payload['title'] ?? null,
            'transcription' => $this->payload['text'] ?? null,
            'summary' => $this->payload['summary'] ?? null,
            'tags' => $this->payload['tags'] ?? null,
            'language' => $this->payload['language'] ?? 'en',
            'duration' => $this->payload['duration'] ?? 0,
            'fileSize' => $this->payload['fileSize'] ?? 0,
            'status' => $this->payload['status'] ?? 'PENDING',
            'keywords' => $this->payload['keywords'] ?? null,
            'metadata' => !empty($this->payload['metadata']) ? json_encode($this->payload['metadata']) : null,
        ];

        // encode the tags if it is an array
        if(is_array($data['tags'])) {
            $data['tags'] = json_encode($data['tags']);
        }

        // create the transcription
        $transcriptionId = $this->transcriptionsModel->createRecord($data);

        // check if the transcription was created
        if(empty($transcriptionId)) {
            return Routing::error('Failed to create transcription record');
        }

        // set the unique ID
        $this->uniqueId = $transcriptionId;

        $record = $this->view()['data'];

        return Routing::created(['data' => 'Transcription record successfully created', 'record' => $record]);

    }

    /**
     * Update a transcription
     * 
     * @return array
     */
    public function update() {

        if(empty($this->uniqueId)) {
            return Routing::error('Transcription ID is required');
        }

        $payload = ['id' => $this->uniqueId];
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $checkExits = $this->transcriptionsModel->checkExists($payload);
        if(empty($checkExits)) {
            return Routing::error('Transcription not found');
        }

        $payload = [];

        // set the 
        if(!empty($this->payload['generateSummary'])) {
            $openAI = new OpenAI();

            $summary = !empty($checkExits['summary']) ? json_decode($checkExits['summary'], true) : [];
            if(empty($summary['actionItems']) && empty($summary['keyPoints'])) {
                $summary = $openAI->analyzeResponse($checkExits['transcription']);
                $payload['summary'] = json_encode($summary);
            }
        }

        foreach(['title', 'description', 'summary', 'tags', 'transcription', 'status', 'keywords'] as $key) {
            if(isset($this->payload[$key])) {
                $payload[$key] = is_array($this->payload[$key]) ? json_encode($this->payload[$key]) : $this->payload[$key];
            }
        }

        if(!empty($payload)) {
            $this->transcriptionsModel->updateRecord($this->uniqueId, $payload);
        }

        return Routing::updated('Transcription record successfully updated', $this->view()['data']);
    }

    /**
     * Delete a transcription
     * 
     * @return array
     */
    public function delete() {

        if(empty($this->uniqueId)) {
            return Routing::error('Transcription ID is required');
        }

        $payload = ['id' => $this->uniqueId];
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $checkExits = $this->transcriptionsModel->checkExists($payload);
        if(empty($checkExits)) {
            return Routing::error('Transcription not found');
        }

        $data = $this->transcriptionsModel->deleteRecord($this->uniqueId);
        if(empty($data)) {
            return Routing::error('Failed to delete transcription record');
        }

        return Routing::success(['data' => 'Transcription record successfully deleted']);

    }

}