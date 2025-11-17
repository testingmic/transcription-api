<?php

/**
 * Format the transcription response
 * 
 * @param array $transcription
 * 
 * @return array
 */
function formatTranscription($transcription, $removeSummary = false) {

    // if the transcription is empty, return an empty array
    if(empty($transcription)) return [];

    // format the transcription response
    foreach($transcription as $key => $value) {
        
        $value['metadata'] = !empty($value['metadata']) ? json_decode($value['metadata'], true) : [];
        $value['tags'] = !empty($value['tags']) ? json_decode($value['tags'], true) : [];
        $value['summary'] = !empty($value['summary']) ? json_decode($value['summary'], true) : [];
        $value['text'] = $value['transcription'];

        $value['summarySet'] = false;
        if(!empty($value['summary']) && !empty($value['summary']['actionItems']) && !empty($value['summary']['keyPoints'])) {
            $value['summarySet'] = true;
        }

        if($removeSummary) {
            unset($value['summary']);
        }

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

/**
 * Get the subscription plans
 * 
 * @return array
 */
function subscriptionPlans() {

    return [
        'FREE' => [
            'id' => 'free',
            'name' => 'Free',
            'price' => 0,
            'minutesLimit' => 30,
            'maxFileSize' => 2, // MB
            'features' => [
                'speakerDiarization' => false,
                'priorityProcessing' => false,
                'cloudStorage' => false,
                'exportFormats' => ['TXT'],
            ]
        ],
        'PRO' => [
            'id' => 'pro',
            'name' => 'Pro',
            'price' => 5.99,
            'minutesLimit' => 600,
            'maxFileSize' => 20, // MB
            'features' => [
                'speakerDiarization' => true,
                'priorityProcessing' => true,
                'cloudStorage' => true,
                'exportFormats' => ['TXT', 'SRT', 'VTT', 'JSON'],
            ],
            'planInfo' => [
                'test' => [
                    'id' => 'PLN_bsio296x9lf1fyq',
                    'paylink' => 'https://paystack.shop/pay/59e8uzx5fn',
                ],
                'live' => [
                    'id' => 'PLN_464xt3ldp7zlgzm',
                    'paylink' => 'https://paystack.shop/pay/iyktl7c-07',
                ]
            ],
        ],
        'PREMIUM' => [
            'id' => 'premium',
            'name' => 'Premium',
            'price' => 9.99,
            'minutesLimit' => 600 * 2.5,
            'maxFileSize' => 50, // MB
            'features' => [
                'speakerDiarization' => true,
                'priorityProcessing' => true,
                'cloudStorage' => true,
                'exportFormats' => ['TXT', 'SRT', 'VTT', 'JSON'],
            ],
            'planInfo' => [
                'test' => [
                    'id' => 'PLN_zdl1ublpc3glnee',
                    'paylink' => 'https://paystack.shop/pay/kssum9d2ez',
                ],
                'live' => [
                    'id' => 'PLN_exyuwncyzagx3fi',
                    'paylink' => 'https://paystack.shop/pay/ce6pmf-do-',
                ]
            ],
        ],
    ];

}