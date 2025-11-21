<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $appName; ?> - AI-Powered Audio Transcription | Fast, Accurate & Secure</title>
    <meta name="description" content="Transform your audio into accurate text transcriptions with AI-powered technology. Fast, secure, and reliable transcription service for iOS and Android.">
    <meta name="keywords" content="audio transcription, speech to text, AI transcription, voice transcription, transcription service">
    <meta name="author" content="Verba Stream">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <link rel="icon" href="<?= $baseUrl ?>assets/images/logo.png">
    <meta property="og:image" content="<?= $baseUrl ?>assets/images/logo.png">
    <meta property="og:image:width" content="100">
    <meta property="og:image:height" content="100">
    <meta property="og:title" content="<?= $appName; ?> - AI-Powered Audio Transcription">
    <meta property="og:description" content="Fast, accurate, and secure audio transcription powered by AI">
    <!-- Android -->
    <meta name="android-app-name" content="<?= $appName; ?>">
    <meta name="android-app-url" content="<?= $baseUrl ?>">
    <meta property="og:url" content="<?= $baseUrl ?>">
    <meta property="og:site_name" content="<?= $appName; ?>">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $appName; ?> - AI-Powered Audio Transcription">
    <meta name="twitter:description" content="Fast, accurate, and secure audio transcription powered by AI">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "<?= $appName; ?>",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "iOS, Android",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        },
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "ratingCount": "<?= isset($totalTranscriptions) ? $totalTranscriptions : '1000' ?>"
        },
        "description": "AI-powered transcription service for accurate and fast audio-to-text conversion"
    }
    </script>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/styles.css">
    <style>
        .h-15 {
            height: 4.5rem !important;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#2563EB',
                        'blue-light': '#3B82F6',
                        'blue-medium': '#2563EB',
                        'blue-dark': '#1E40AF',
                        'accent-cyan': '#06B6D4',
                        'accent-sky': '#0EA5E9',
                        'accent-indigo': '#6366F1',
                        'accent-emerald': '#10B981',
                    },
                    backgroundImage: {
                        'gradient-primary': 'linear-gradient(135deg, #3B82F6 0%, #2563EB 100%)',
                        'gradient-hero': 'linear-gradient(135deg, #2563EB 0%, #1E40AF 50%, #1E3A8A 100%)',
                        'gradient-accent': 'linear-gradient(135deg, #2563EB 0%, #6366F1 100%)',
                        'gradient-light': 'linear-gradient(135deg, #60A5FA 0%, #3B82F6 100%)',
                    }
                }
            }
        }
    </script>
    <script>
        const baseUrl = "<?= $baseUrl ?>";
    </script>
</head>
<body class="bg-gray-50">