
<!-- Skip to main content link for accessibility -->
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-blue-800 focus:text-white focus:rounded-lg">Skip to main content</a>

<!-- Navigation -->
<nav id="navbar" class="bg-white/80 backdrop-blur-lg sticky top-0 z-50 border-b border-gray-200/50 transition-all duration-300" role="navigation" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="<?= $baseUrl ?>" class="flex items-center gap-3 text-2xl font-bold" style="color: #1db3ff;" aria-label="Verba Stream Home">
                    <img src="<?= $baseUrl ?>assets/images/logo.png" alt="Verba Stream Logo" class="h-15 w-auto">
                    <span><?= $appName; ?></span>
                </a>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#features" class="text-gray-700 hover:text-blue-800 transition font-medium focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-offset-2 rounded">Features</a>
                <a href="#how-it-works" class="text-gray-700 hover:text-blue-800 transition font-medium focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-offset-2 rounded">How It Works</a>
                <a href="<?= $baseUrl ?>pricing" class="text-gray-700 hover:text-blue-800 transition font-medium focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-offset-2 rounded">Pricing</a>
                <a href="#testimonials" class="text-gray-700 hover:text-blue-800 transition font-medium focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-offset-2 rounded">Reviews</a>
                <a href="#faq" class="text-gray-700 hover:text-blue-800 transition font-medium focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-offset-2 rounded">FAQ</a>
                <a href="<?= $baseUrl ?>contact" class="text-gray-700 hover:text-blue-800 transition font-medium focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-offset-2 rounded">Contact</a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="text-gray-700 hover:text-blue-800 transition focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-offset-2 rounded p-2" aria-label="Toggle mobile menu" aria-expanded="false" aria-controls="mobile-menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-lg border-t border-gray-200" role="menu">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="#features" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-800" role="menuitem">Features</a>
            <a href="#how-it-works" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-800" role="menuitem">How It Works</a>
            <a href="<?= $baseUrl ?>pricing" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-800" role="menuitem">Pricing</a>
            <a href="#testimonials" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-800" role="menuitem">Reviews</a>
            <a href="#faq" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-800" role="menuitem">FAQ</a>
            <a href="<?= $baseUrl ?>contact" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-800" role="menuitem">Contact</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="main-content" class="gradient-hero text-white py-20 md:py-22 relative overflow-hidden" aria-label="Hero section">
    <!-- Enhanced animated background elements - Blue theme -->
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-r from-blue-400 to-blue-500 rounded-full filter blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full filter blur-3xl animate-float" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-gradient-to-r from-blue-300 to-indigo-400 rounded-full filter blur-3xl animate-float" style="animation-delay: 3s;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Left Column: Text Content -->
            <div class="text-center md:text-left fade-in-on-scroll">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Transform Audio into Text with AI Precision
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-white/90 leading-relaxed">
                    Fast, accurate, and secure transcription powered by advanced AI. Get your audio transcribed in minutes, not hours.
                </p>
                
                <!-- Enhanced Key Benefits -->
                <div class="flex flex-wrap gap-4 mb-8 justify-center md:justify-start">
                    <div class="flex items-center glass-card px-5 py-3 rounded-full shadow-colored hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-emerald-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900 font-semibold">99% Accurate</span>
                    </div>
                    <div class="flex items-center glass-card px-5 py-3 rounded-full shadow-colored hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900 font-semibold">Lightning Fast</span>
                    </div>
                    <div class="flex items-center glass-card px-5 py-3 rounded-full shadow-colored hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900 font-semibold">Secure & Private</span>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Right Column: Stats Card -->
            <div class="fade-in-on-scroll" style="transition-delay: 0.3s;">
                <div class="bg-white/95 backdrop-blur-xl p-8 rounded-3xl shadow-colored-lg border border-white/20">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Trusted by Thousands</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center p-4 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 hover:shadow-md transition-shadow">
                            <div class="text-4xl font-bold text-blue-700 mb-2">
                                <?= $totalTranscriptions ?>+
                            </div>
                            <div class="text-gray-700 text-sm font-medium">Transcriptions</div>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-50 hover:shadow-md transition-shadow">
                            <div class="text-4xl font-bold text-blue-600 mb-2"><?= $activeUsers ?>+</div>
                            <div class="text-gray-700 text-sm font-medium">Active Users</div>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-gradient-to-br from-emerald-50 to-cyan-50 hover:shadow-md transition-shadow">
                            <div class="text-4xl font-bold text-emerald-600 mb-2">99%</div>
                            <div class="text-gray-700 text-sm font-medium">Accuracy Rate</div>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-gradient-to-br from-cyan-50 to-blue-50 hover:shadow-md transition-shadow">
                            <div class="text-4xl font-bold text-blue-700 mb-2">50+</div>
                            <div class="text-gray-700 text-sm font-medium">Languages</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Powerful Features</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Everything you need for accurate, fast transcription
            </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="feature-card glass-card p-8 rounded-2xl card-hover fade-in-on-scroll border border-gray-100">
                <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mb-6 icon-bounce shadow-colored">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Real-Time Transcription</h3>
                <p class="text-gray-600 leading-relaxed">Get instant transcriptions as you speak. No waiting, no delays - just pure speed.</p>
            </div>
            
            <div class="feature-card glass-card p-8 rounded-xl card-hover fade-in-on-scroll" style="transition-delay: 0.2s;">
                <div class="w-14 h-14 bg-gradient-to-r from-blue-800 to-blue-900 rounded-xl flex items-center justify-center mb-6 icon-bounce">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Cloud Sync & Storage</h3>
                <p class="text-gray-600">Access your transcriptions anywhere, anytime. Secure cloud storage included.</p>
            </div>
            
            <div class="feature-card glass-card p-8 rounded-xl card-hover fade-in-on-scroll" style="transition-delay: 0.4s;">
                <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6 icon-bounce">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">AI-Powered Accuracy</h3>
                <p class="text-gray-600">Advanced machine learning ensures 99%+ accuracy with context understanding.</p>
            </div>
            
            <div class="feature-card glass-card p-8 rounded-xl card-hover fade-in-on-scroll" style="transition-delay: 0.5s;">
                <div class="w-14 h-14 gradient-secondary rounded-xl flex items-center justify-center mb-6 icon-bounce">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Export Options</h3>
                <p class="text-gray-600">Export in TXT, PDF, DOCX, or share directly to your favorite apps.</p>
            </div>
            
            <div class="feature-card glass-card p-8 rounded-xl card-hover fade-in-on-scroll" style="transition-delay: 0.1s;">
                <div class="w-14 h-14 bg-gradient-to-r from-blue-700 to-blue-900 rounded-xl flex items-center justify-center mb-6 icon-bounce">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Multi-Language Support</h3>
                <p class="text-gray-600">Transcribe in 50+ languages and dialects with native-level accuracy.</p>
            </div>
            
            <div class="feature-card glass-card p-8 rounded-xl card-hover fade-in-on-scroll" style="transition-delay: 0.3s;">
                <div class="w-14 h-14 bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl flex items-center justify-center mb-6 icon-bounce">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Offline Capability</h3>
                <p class="text-gray-600">Work without internet. Transcribe offline and sync when connected.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Simple, fast, and accurate transcription in three easy steps
            </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center fade-in-on-scroll">
                <div class="w-24 h-24 gradient-primary rounded-full flex items-center justify-center mx-auto mb-6 text-white text-4xl font-bold transform transition-transform hover:scale-110 shadow-lg">
                    1
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Record or Upload</h3>
                <p class="text-gray-600">Record audio directly in the app or upload files from your device. Supports all major audio formats.</p>
            </div>
            <div class="text-center fade-in-on-scroll" style="transition-delay: 0.2s;">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-700 to-blue-900 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-4xl font-bold transform transition-transform hover:scale-110 shadow-lg">
                    2
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">AI Transcribes</h3>
                <p class="text-gray-600">Our advanced AI analyzes and transcribes your audio with high accuracy in minutes.</p>
            </div>
            <div class="text-center fade-in-on-scroll" style="transition-delay: 0.4s;">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-800 to-blue-900 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-4xl font-bold transform transition-transform hover:scale-110 shadow-lg">
                    3
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Edit & Export</h3>
                <p class="text-gray-600">Review, edit, and export your transcription in your preferred format or share instantly.</p>
            </div>
        </div>
    </div>
</section>


<!-- Testimonials Section -->
<section id="testimonials" class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our Users Say</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Join thousands of satisfied users who trust <?= $appName; ?>
            </p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="glass-card p-6 rounded-xl fade-in-on-scroll">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-700 to-blue-900 rounded-full flex items-center justify-center text-white font-bold">
                        JO
                    </div>
                    <div class="ml-4">
                        <div class="font-semibold text-gray-900">John</div>
                        <div class="text-sm text-gray-600">Journalist</div>
                    </div>
                </div>
                <div class="flex text-yellow-400 mb-3">
                    ★★★★★
                </div>
                <p class="text-gray-700">"Incredibly accurate transcription! Saves me hours every week. The multi-language support is a game-changer for my international interviews."</p>
            </div>
            
            <div class="glass-card p-6 rounded-xl fade-in-on-scroll" style="transition-delay: 0.1s;">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-800 to-blue-700 rounded-full flex items-center justify-center text-white font-bold">
                        EM
                    </div>
                    <div class="ml-4">
                        <div class="font-semibold text-gray-900">Emmanuel</div>
                        <div class="text-sm text-gray-600">Student</div>
                    </div>
                </div>
                <div class="flex text-yellow-400 mb-3">
                    ★★★★★
                </div>
                <p class="text-gray-700">"Perfect for transcribing lectures. The offline feature works great when I'm in areas with poor connectivity. Highly recommend!"</p>
            </div>
            
            <div class="glass-card p-6 rounded-xl fade-in-on-scroll" style="transition-delay: 0.2s;">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-700 to-blue-900 rounded-full flex items-center justify-center text-white font-bold">
                        SI
                    </div>
                    <div class="ml-4">
                        <div class="font-semibold text-gray-900">Simon</div>
                        <div class="text-sm text-gray-600">Content Creator</div>
                    </div>
                </div>
                <div class="flex text-yellow-400 mb-3">
                    ★★★★★
                </div>
                <p class="text-gray-700">"The real-time transcription feature is amazing for live streams. Export options are perfect for my workflow. Best transcription app I've used!"</p>
            </div>
            
            <div class="glass-card p-6 rounded-xl fade-in-on-scroll" style="transition-delay: 0.3s;">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-800 to-blue-900 rounded-full flex items-center justify-center text-white font-bold">
                        FR
                    </div>
                    <div class="ml-4">
                        <div class="font-semibold text-gray-900">Fred</div>
                        <div class="text-sm text-gray-600">Business Owner</div>
                    </div>
                </div>
                <div class="flex text-yellow-400 mb-3">
                    ★★★★★
                </div>
                <p class="text-gray-700">"Enterprise plan is worth every penny. The API integration and dedicated support have streamlined our entire workflow. Excellent service!"</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-xl text-gray-600">
                Everything you need to know about <?= $appName; ?>
            </p>
        </div>
        <div class="space-y-4">
            <div class="faq-item glass-card rounded-xl overflow-hidden fade-in-on-scroll">
                <button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/50 transition">
                    <span class="font-semibold text-gray-900">How accurate is the transcription?</span>
                    <svg class="faq-icon w-5 h-5 text-blue-800 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content">
                    <div class="px-6 pb-4 text-gray-700">
                        Our AI-powered transcription achieves 99%+ accuracy for clear audio. Accuracy may vary based on audio quality, background noise, accents, and technical terminology. We continuously improve our models to handle various scenarios.
                    </div>
                </div>
            </div>
            
            <div class="faq-item glass-card rounded-xl overflow-hidden fade-in-on-scroll" style="transition-delay: 0.1s;">
                <button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/50 transition">
                    <span class="font-semibold text-gray-900">What audio formats are supported?</span>
                    <svg class="faq-icon w-5 h-5 text-blue-800 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content">
                    <div class="px-6 pb-4 text-gray-700">
                        We support all major audio formats including MP3, WAV, M4A, AAC, FLAC, and more. You can also record directly in the app. Maximum file size varies by plan (10 minutes for Free, 2 hours for Pro).
                    </div>
                </div>
            </div>
            
            <div class="faq-item glass-card rounded-xl overflow-hidden fade-in-on-scroll" style="transition-delay: 0.2s;">
                <button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/50 transition">
                    <span class="font-semibold text-gray-900">Is my data secure and private?</span>
                    <svg class="faq-icon w-5 h-5 text-blue-800 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content">
                    <div class="px-6 pb-4 text-gray-700">
                        Absolutely. We use end-to-end encryption for all audio files and transcriptions. Your data is stored on secure servers and is never shared with third parties. We comply with GDPR, CCPA, and other privacy regulations. 
                        See our <a href="<?= $baseUrl ?>privacy" class="text-blue-800 hover:underline">Privacy Policy</a> for details.
                    </div>
                </div>
            </div>
            
            <div class="faq-item glass-card rounded-xl overflow-hidden fade-in-on-scroll" style="transition-delay: 0.3s;">
                <button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/50 transition">
                    <span class="font-semibold text-gray-900">Can I cancel my subscription anytime?</span>
                    <svg class="faq-icon w-5 h-5 text-blue-800 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content">
                    <div class="px-6 pb-4 text-gray-700">
                        Yes, you can cancel your subscription at any time through your account settings or via RevenueCat. Your subscription will remain active until the end of the current billing period, and you'll continue to have access to all Pro features until then.
                    </div>
                </div>
            </div>
            
            <div class="faq-item glass-card rounded-xl overflow-hidden fade-in-on-scroll" style="transition-delay: 0.4s;">
                <button class="faq-question w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/50 transition">
                    <span class="font-semibold text-gray-900">Does it work offline?</span>
                    <svg class="faq-icon w-5 h-5 text-blue-800 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content">
                    <div class="px-6 pb-4 text-gray-700">
                        Yes! Pro and Enterprise users can transcribe audio offline. Transcriptions will sync to the cloud automatically when you reconnect to the internet. Offline mode uses on-device AI processing for privacy and speed.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 gradient-hero text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-10 left-20 w-64 h-64 bg-white rounded-full filter blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-20 w-80 h-80 bg-blue-300 rounded-full filter blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 fade-in-on-scroll">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-xl mb-8 text-white/90 max-w-2xl mx-auto">
            Download <?= $appName; ?> mobile app and start transcribing your audio files today.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://apps.apple.com/app/verba-stream" 
               target="_blank" 
               rel="noopener noreferrer"
               class="btn-primary glass-card text-gray-900 px-8 py-4 rounded-lg font-semibold hover:bg-white/90 transition shadow-xl inline-flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-800"
               aria-label="Download Verba Stream on the App Store">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.05 20.28c-.98.95-2.05.88-3.08.33-1.09-.58-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.33C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                </svg>
                App Store
            </a>
            <a href="https://play.google.com/store/apps/details?id=com.verbastream" 
               target="_blank" 
               rel="noopener noreferrer"
               class="btn-primary glass-card text-gray-900 px-8 py-4 rounded-lg font-semibold hover:bg-white/90 transition shadow-xl inline-flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-800"
               aria-label="Download Verba Stream on Google Play">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
                </svg>
                Google Play
            </a>
        </div>
        <p class="mt-4 text-sm text-white/80">
            <a href="<?= $baseUrl ?>pricing" class="underline hover:text-white transition">View pricing plans</a> or <a href="<?= $baseUrl ?>contact" class="underline hover:text-white transition">contact us</a> for enterprise solutions
        </p>
    </div>
</section>