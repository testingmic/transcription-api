<?php
/**
 * @param string $key
 * 
 * @return mixed
 */
function configs($key) {

    $configuration = [
        'db_group' => config('Database')?->defaultGroup,
        'algo' => config('Security')?->algo,
        'salt' => config('Security')?->salt,
        'testing_mode' => config('General')?->testing_mode,
        'tracking_ttl' => 6,
        'appName' => getenv('APP_NAME'),
        'app_url' => getenv('baseURL'),
        'heatmaps_ttl' => (60 * 30 * 1),
        'is_local' => config('Database')?->defaultGroup == 'tests',
        'app_theme' => getenv('APP_THEME'),
        'openai_api_key' => getenv('OPENAI_API_KEY2'),
        
        'paystack_account_id' => getenv('PAYSTACK_ACCOUNT_ID'),

        'paystack_test_secret' => getenv('PAYSTACK_TEST_SECRET'),
        'paystack_live_secret' => getenv('PAYSTACK_LIVE_SECRET'),

        'paystack_test_public' => getenv('PAYSTACK_TEST_PUBLIC_KEY'),
        'paystack_live_public' => getenv('PAYSTACK_LIVE_PUBLIC_KEY'),

        // email config
        'email.port' => getenv('email.SMTP_PORT'),
        'email.host' => getenv('email.SMTP_HOST'),
        'email.user' => getenv('email.SMTP_USER'),
        'email.pass' => getenv('email.SMTP_PASSWORD'),
        'email.crypto' => getenv('email.SMTP_CRYPTO'),
    ];

    return $configuration[$key] ?? null;

}
?>