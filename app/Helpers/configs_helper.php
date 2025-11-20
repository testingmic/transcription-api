<?php
/**
 * @param string $key
 * 
 * @return mixed
 */
function configs($key) {

    $configuration = [
        'app_name' => 'MobileTranscribe.com',
        'db_group' => config('Database')?->defaultGroup,
        'algo' => config('Security')?->algo,
        'salt' => config('Security')?->salt,
        'testing_mode' => config('General')?->testing_mode,
        'tracking_ttl' => 6,
        'appName' => 'MobileTranscribe.com',
        'app_url' => getenv('baseURL'),
        'heatmaps_ttl' => (60 * 30 * 1),
        'is_local' => getenv('LOCAL_ENVIRONMENT') == 'yes',
        'app_theme' => getenv('APP_THEME'),
        'openai_api_key' => getenv('OPENAI_API_KEY2'),
        
        // paystack config
        'paystack_account_id' => getenv('PAYSTACK_ACCOUNT_ID'),

        'paystack_test_secret' => getenv('PAYSTACK_TEST_SECRET'),
        'paystack_live_secret' => getenv('PAYSTACK_LIVE_SECRET'),

        'paystack_test_public' => getenv('PAYSTACK_TEST_PUBLIC_KEY'),
        'paystack_live_public' => getenv('PAYSTACK_LIVE_PUBLIC_KEY'),

        // currency key
        'currency_key' => getenv('CURRENCY_KEYS'),

        // email config
        'email.port' => getenv('SMTP_PORT'),
        'email.host' => getenv('SMTP_HOST'),
        'email.user' => getenv('SMTP_USER'),
        'email.pass' => getenv('SMTP_PASSWORD'),
        'email.crypto' => getenv('SMTP_CRYPTO'),
    ];

    return $configuration[$key] ?? null;

}
?>