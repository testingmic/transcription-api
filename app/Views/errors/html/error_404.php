<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Verba Stream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/styles.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-blue-800">404</h1>
                <h2 class="text-3xl font-bold text-gray-900 mt-4 mb-2">Page Not Found</h2>
                <p class="text-gray-600 mb-8">Sorry, we couldn't find the page you're looking for.</p>
            </div>
            <div class="space-y-4">
                <a href="<?= base_url() ?>" class="inline-block gradient-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-900 transition shadow-lg">
                    Go Home
                </a>
                <div class="text-sm text-gray-600">
                    <p>Or try:</p>
                    <ul class="mt-2 space-y-1">
                        <li><a href="<?= base_url() ?>#features" class="text-blue-800 hover:underline">Features</a></li>
                        <li><a href="<?= base_url() ?>pricing" class="text-blue-800 hover:underline">Pricing</a></li>
                        <li><a href="<?= base_url() ?>contact" class="text-blue-800 hover:underline">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

