<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | Verba Stream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/styles.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-red-600">500</h1>
                <h2 class="text-3xl font-bold text-gray-900 mt-4 mb-2">Server Error</h2>
                <p class="text-gray-600 mb-8">Something went wrong on our end. We're working to fix it.</p>
            </div>
            <div class="space-y-4">
                <a href="<?= base_url() ?>" class="inline-block gradient-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-900 transition shadow-lg">
                    Go Home
                </a>
                <div class="text-sm text-gray-600">
                    <p>If the problem persists, please <a href="<?= base_url() ?>contact" class="text-blue-800 hover:underline">contact support</a>.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

