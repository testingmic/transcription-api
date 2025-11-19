<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appName; ?> - AI-Powered Audio Transcription | Fast, Accurate & Secure</title>
    <meta name="description" content="Transform your audio into accurate text transcriptions with AI-powered technology. Fast, secure, and reliable transcription service for iOS and Android.">
    <meta property="og:title" content="<?= $appName; ?> - AI-Powered Audio Transcription">
    <meta property="og:description" content="Fast, accurate, and secure audio transcription powered by AI">
    <meta property="og:type" content="website">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/styles.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#1E40AF',
                        'blue-500': '#3B82F6',
                        'blue-600': '#2563EB',
                        'blue-700': '#1D4ED8',
                        'blue-800': '#1E40AF',
                        'blue-900': '#1E3A8A',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">