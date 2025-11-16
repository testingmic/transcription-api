<?php

namespace App\Libraries;

use App\Controllers\LoadController;
use App\Models\ResourcesModel;

use Exception;

class Resources extends LoadController {

    private $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private $allowedVideoTypes = ['video/mp4', 'video/webm', 'video/quicktime'];
    private $allowedAudioTypes = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/x-wav', 'audio/wave', 'audio/x-m4a', 'audio/m4a', 'audio/aac', 'audio/ogg', 'audio/webm'];
    private $maxImageSize = 5;
    private $maxVideoSize = 20;
    private $maxAudioSize = 10;
    private $uploadPath;
    private $thumbnailPath;
    private $audioPath;

    /**
     * Ensure the directories exist
     */
    private function ensureDirectoriesExist() {
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
        if (!file_exists($this->thumbnailPath)) {
            mkdir($this->thumbnailPath, 0755, true);
        }
    }

    /**
     * Upload media
     * @param string $section
     * @param int $recordId
     * @param int $userId
     * @param array $filesList
     * 
     * @return array
     */
    public function uploadMedia($section, $recordId, $userId, $filesList) {

        try {

            // create the upload path
            $today = date('Ymd');

            $uploadPath = "media/" . $today . "/";

            $this->audioPath = rtrim(PUBLICPATH, "/") . "/uploads/audio/" . $today . "/";

            $uploadedList = [];
            $resultsList = [];

            // get the video thumbnails
            $videoThumbnail = $filesList['thumbnails'] ?? [];

            // create a new instance of the ResourcesModel
            $mediaModel = new ResourcesModel();

            // Process audio files separately
            if(!empty($filesList['audio'])) {
                if (!file_exists($this->audioPath)) {
                    mkdir($this->audioPath, 0755, true);
                }

                // Normalize to array if it's a single file
                $audioFiles = is_array($filesList['audio']) ? $filesList['audio'] : [$filesList['audio']];
                
                foreach($audioFiles as $key => $file) {

                    $uploadedList = [];
                    // validate the file uploaded
                    if(!$file->isValid() || $file->hasMoved()) {
                        continue;
                    }

                    // create a new object of the File class
                    $theFile = new \CodeIgniter\Files\File($file);
                    
                    // get the audio information
                    $originalName = $file->getName();
                    $extension = $theFile->guessExtension();
                    $megabytes = $theFile->getSizeByUnit('mb');
                    $bytesSize = $theFile->getSize();
                    $mimeType = $theFile->getMimeType();

                    // validate audio file
                    if($megabytes > $this->maxAudioSize) {
                        continue;
                    }

                    if(!in_array($mimeType, $this->allowedAudioTypes)) {
                        continue;
                    }

                    // create a new name for the file
                    $newName = $this->createRandomNameUUIDFormat($originalName);

                    $data = [
                        'user_id' => $userId,
                        'size' => $bytesSize,
                        'audioUrl' => "audio/" . $today . "/" . $newName,
                        'transcription_id' => $recordId,
                        'mimeType' => $mimeType,
                    ];

                    // move the file to the audio upload path
                    $file->move($this->audioPath, $newName);

                    // if the record is created successfully, add the record to the results list
                    if(!empty($data)) {
                        $result = $mediaModel->createMediaRecord($data, $recordId, $userId);
                        $resultsList[$data['audioUrl']] = $result;
                    }
                }
            }

            // Process media files (images and videos)
            if(!empty($filesList['media'])) {

                // set the upload and thumbnail paths
                $this->uploadPath = rtrim(PUBLICPATH, "/") . "/uploads/media/" . $today . "/";
                $this->thumbnailPath = rtrim(PUBLICPATH, "/") . "/uploads/media/" . $today . "/thumbnails/";

                $this->ensureDirectoriesExist();

                // Normalize to array if it's a single file
                $mediaFiles = is_array($filesList['media']) ? $filesList['media'] : [$filesList['media']];
                
                foreach($mediaFiles as $key => $file) {

                    $uploadedList = [];

                    // validate the file uploaded
                    if(!$file->isValid() || $file->hasMoved()) {
                        continue;
                    }

                    // create a new object of the File class
                    $theFile = new \CodeIgniter\Files\File($file);
                    
                    // get the media information
                    $originalName = $file->getName();
                    $megabytes = $theFile->getSizeByUnit('mb');
                    $mimeType = $theFile->getMimeType();
                    $bytesSize = $theFile->getSize();

                    // create a new name for the file
                    $newName = $this->createRandomNameUUIDFormat($originalName);

                    $isImage = (strpos($mimeType, 'image') !== false);
                    
                    if($isImage) {
                        if(!in_array($mimeType, $this->allowedImageTypes)) {
                            continue;
                        }
                        if($megabytes > $this->maxImageSize) {
                            continue;
                        }

                        // move the file to the upload path
                        $file->move($this->uploadPath, $newName);
                        
                        $this->createImageThumbnail($this->uploadPath . $newName, $this->thumbnailPath . '300x300_' . $newName);

                        $thumbUrl =  $uploadPath . 'thumbnails/300x300_' . $newName;
                    } else {
                        // Handle video
                        if(!in_array($mimeType, $this->allowedVideoTypes)) {
                            continue;
                        }
                        if($megabytes > $this->maxVideoSize) {
                            continue;
                        }

                        // move the file to the upload path
                        $file->move($this->uploadPath, $newName);

                        // get the video thumbnail
                        $vidThumb = $videoThumbnail[$key] ?? null;

                        if(!empty($vidThumb)) {
                            // move the thumbnail to the thumbnail path
                            $vidThumb->move($this->thumbnailPath, explode('.', $newName)[0] . '.jpg');
                            // add the thumbnail to the uploaded list
                            $thumbUrl = $uploadPath . 'thumbnails/'. explode('.', $newName)[0] . '.jpg';
                        }
                    }

                    $data = [
                        'user_id' => $userId,
                        'size' => $bytesSize,
                        'audioUrl' => $uploadPath . $newName,
                        'transcription_id' => $recordId,
                        'thumbnails' => $thumbUrl,
                        'mimeType' => $mimeType,
                    ];
                    
                    // if the record is created successfully, add the record to the results list
                    if(!empty($data)) {
                        $result = $mediaModel->createMediaRecord($data, $recordId, $userId);
                        $resultsList[$data['audioUrl']] = $result;
                    }
                }
            }

            // return the uploaded list
            return $resultsList;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Create a thumbnail for an image
     * @param string $sourcePath
     * @param string $thumbPath
     * @param int $width
     * @param int $height
     */
    public function createImageThumbnail($sourcePath, $thumbPath, $width = 250, $height = 250)
    {
        $image = \Config\Services::image()
            ->withFile($sourcePath)
            ->resize($width, $height, true, 'width')
            ->save($thumbPath);
    }

    /**
     * Create a random name in UUID format
     * @param string $originalName
     * @return string
     */
    private function createRandomNameUUIDFormat($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    
        return $extension ? $uuid . '.' . ltrim($extension, '.') : $uuid;
    }

} 