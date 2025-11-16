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