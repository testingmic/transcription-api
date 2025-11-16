<?php

/**
 * Format the transcription response
 * 
 * @param array $transcription
 * 
 * @return array
 */
function formatTranscription($transcription) {

    // if the transcription is empty, return an empty array
    if(empty($transcription)) return [];

    // format the transcription response
    foreach($transcription as $key => $value) {
        
        $value['metadata'] = !empty($value['metadata']) ? json_decode($value['metadata'], true) : [];
        $value['tags'] = !empty($value['tags']) ? json_decode($value['tags'], true) : [];
        $value['summary'] = !empty($value['summary']) ? json_decode($value['summary'], true) : [];
        $value['text'] = $value['transcription'];

        if(!empty($value['audioUrl'])) {
            $value['audioUrl'] = base_url("uploads/{$value['audioUrl']}");
        }

        $result[] = $value;
    }

    return $result;
}

/**
 * Format the audio response
 * 
 * @param array $audios
 * 
 * @return array
 */
function formatAudio($audios) {

    if(empty($audios)) return [];

    // format the transcription response
    foreach($audios as $key => $value) {
        $result[] = $value;
    }

    return $result;
}