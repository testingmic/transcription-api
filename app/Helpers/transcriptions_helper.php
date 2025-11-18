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

        // decode the html entities
        $value['transcription'] = html_entity_decode($value['transcription'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value['transcription'] = str_ireplace(['&amp;#039;'], ['\''], $value['transcription']);

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
 * Convert the revenue from the incoming currency into usd
 * 
 * @param int		$revenue
 * @param string	$from
 * @param string	$to
 * 
 * @return mixed
 */
function revenue_conversion($revenue, $from = 'GHS', $to = 'USD', $cacheObject = null) {

    global $loadedCurrencies;

    if(empty($cacheObject)) {
        return [
            'revenue' => $revenue,
            'converted' => 0
        ];
    }

    // if the currencies are not loaded, then load them
    if(empty($loadedCurrencies)) {
        $cacheKey = create_cache_key('currency', 'lookup', ['revenue' => 'currency_list']);
        $loadedCurrencies = $cacheObject->get($cacheKey);
    }
    $converted = 0;

    if(empty($loadedCurrencies)) {
        return [
            'revenue' => $revenue,
            'converted' => 0
        ];
    }

    // remove the commas
    $revenue = str_ireplace(',', '', $revenue);

    // get the exchange rates
    $current = $loadedCurrencies;
    if(!empty($current)) {
        $exchangeRates = $current['rates'] ?? $current;
        if (isset($exchangeRates[$from]) && isset($exchangeRates[$to])) {
            $converted = 1;
            $revenue = $revenue * ($exchangeRates[$to] / $exchangeRates[$from]);
        }
    }

    $revenue = round($revenue, 2);

    if(strpos($revenue, '.') == false) {
        if(strlen($revenue) > 4) {
            $revenue = substr($revenue, 0, 3);
        }
    }
    
    return [
        'revenue' => $revenue,
        'converted' => $converted
    ];

}

/**
 * Loop through the currencies
 * 
 * @param string $testKeys
 * 
 * @return array|bool
 */
function loopthroughCurrencies($testKeys = null) {
    try {
        $cur = file_get_contents("https://api.exchangeratesapi.io/v1/latest?access_key={$testKeys}");
        $cur = !empty($cur) ? json_decode($cur, true) : [];

        if(empty($cur) || !isset($cur['rates'])) {
            return false;
        }
        return $cur['rates'];
    } catch(\Exception $e) {
        return false;
    }
}

/**
 * Currency lookup
 * 
 * @return bool
 */
function currencyLookup($cacheObject)
{
    try {
        // check if the currency list is already in the cache
        $cacheKey = create_cache_key('currency', 'lookup', ['revenue' => 'currency_list']);
        $loadCache = $cacheObject->get($cacheKey);

        // if the currency list is already in the cache, return
        if(!empty($loadCache)) {
            return;
        }

        // get the currency keys
        $result = loopthroughCurrencies(configs('currency_key'));
        if(empty($result)) {
            return;
        }

        // save the currency list to the cache
        $cacheObject->save($cacheKey, $result, 'currency.lookup', 'is_admin', (60 * 60 * 2));

    } catch(\Exception $e) { }

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
            'price' => 65.99,
            'minutesLimit' => 600,
            'maxFileSize' => 20, // MB
            'features' => [
                'speakerDiarization' => true,
                'priorityProcessing' => true,
                'cloudStorage' => true,
                'exportFormats' => ['TXT', 'PDF', 'JSON'],
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
            'price' => 119.99,
            'minutesLimit' => 600 * 2.5,
            'maxFileSize' => 50, // MB
            'features' => [
                'speakerDiarization' => true,
                'priorityProcessing' => true,
                'cloudStorage' => true,
                'exportFormats' => ['TXT', 'PDF', 'JSON'],
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