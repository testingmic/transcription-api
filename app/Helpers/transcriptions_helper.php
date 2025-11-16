<?php

/**
 * Format the transcription response
 * 
 * @param array $transcription
 * 
 * @return array
 */
function formatTranscription($transcription) {
    if(empty($transcription)) return [];

    // format the transcription response
    foreach($transcription as $key => $value) {
        $value['metadata'] = !empty($value['metadata']) ? json_decode($value['metadata'], true) : [];
        $value['tags'] = !empty($value['tags']) ? json_decode($value['tags'], true) : [];
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