<!-- Navigation -->
<nav id="navbar" class="bg-white/80 backdrop-blur-lg sticky top-0 z-50 border-b border-gray-200/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="<?= $baseUrl ?>" class="text-2xl font-bold bg-gradient-to-r from-blue-700 to-blue-900 bg-clip-text text-transparent" aria-label="Verba Stream Home">
                    <?= $appName; ?>
                </a>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="<?= $baseUrl ?>" class="text-gray-700 hover:text-blue-800 transition font-medium">Home</a>
                <a href="<?= $baseUrl ?>#features" class="text-gray-700 hover:text-blue-800 transition font-medium">Features</a>
                <a href="<?= $baseUrl ?>pricing" class="text-gray-700 hover:text-blue-800 transition font-medium">Pricing</a>
                <a href="<?= $baseUrl ?>contact" class="text-blue-800 font-semibold" aria-current="page">Contact</a>
                <a href="<?= $baseUrl ?>privacy" class="text-gray-700 hover:text-blue-800 transition font-medium">Privacy</a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="text-gray-700 hover:text-blue-800 transition" aria-label="Toggle mobile menu" aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-lg border-t border-gray-200">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="<?= $baseUrl ?>" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition">Home</a>
            <a href="<?= $baseUrl ?>#features" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition">Features</a>
            <a href="<?= $baseUrl ?>pricing" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition">Pricing</a>
            <a href="<?= $baseUrl ?>contact" class="block px-3 py-2 text-blue-800 font-semibold hover:bg-gray-50 rounded-md transition">Contact</a>
            <a href="<?= $baseUrl ?>privacy" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition">Privacy</a>
        </div>
    </div>
</nav>

<!-- Breadcrumbs -->
<nav aria-label="Breadcrumb" class="bg-gray-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="<?= $baseUrl ?>" class="hover:text-blue-800 transition">Home</a></li>
            <li aria-hidden="true">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-900 font-medium" aria-current="page">Contact</li>
        </ol>
    </div>
</nav>

<!-- Header -->
<header class="gradient-hero text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-10 left-20 w-64 h-64 bg-white rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-10 right-20 w-80 h-80 bg-blue-300 rounded-full filter blur-3xl"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 fade-in-on-scroll">
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-700 to-blue-900 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Get in Touch</h1>
        <p class="text-xl text-white/90">
            Have questions? We're here to help. Send us a message and we'll respond as soon as possible.
        </p>
    </div>
</header>

<!-- Contact Section -->
<main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid md:grid-cols-1 gap-12">
        
        <!-- Contact Information -->
        <div class="space-y-8 fade-in-on-scroll" style="transition-delay: 0.2s;">
            <div class="glass-card p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-800 mr-4 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Email</p>
                            <a href="mailto:support@verbastream.com" data-copy-email="support@verbastream.com" class="text-blue-800 hover:underline">support@verbastream.com</a>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-800 mr-4 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Response Time</p>
                            <p class="text-gray-600">Within 24 hours</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-800 mr-4 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-gray-900">Support Hours</p>
                            <p class="text-gray-600">Monday - Friday, 9 AM - 6 PM EST</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Other Ways to Reach Us</h3>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-800 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Check our <a href="<?= $baseUrl ?>#faq" class="text-blue-800 hover:underline">FAQ section</a> for common questions</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-800 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Visit our <a href="<?= $baseUrl ?>pricing" class="text-blue-800 hover:underline">Pricing page</a> for plan details</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-800 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Read our <a href="<?= $baseUrl ?>privacy" class="text-blue-800 hover:underline">Privacy Policy</a> for data protection info</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</main>

