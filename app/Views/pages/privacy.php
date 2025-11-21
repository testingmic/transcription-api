<!-- Navigation -->
<nav id="navbar" class="bg-white/80 backdrop-blur-lg sticky top-0 z-50 border-b border-gray-200/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="<?= $baseUrl ?>" class="text-2xl font-bold bg-gradient-to-r from-blue-700 to-blue-900 bg-clip-text text-transparent">
                    <?= $appName; ?>
                </a>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="<?= $baseUrl ?>" class="text-gray-700 hover:text-blue-800 transition font-medium">Home</a>
                <a href="<?= $baseUrl ?>privacy" class="text-blue-800 font-semibold">Privacy</a>
                <a href="<?= $baseUrl ?>terms" class="text-gray-700 hover:text-blue-800 transition font-medium">Terms</a>
                <a href="<?= $baseUrl ?>data-deletion" class="text-gray-700 hover:text-blue-800 transition font-medium">Data Deletion</a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="text-gray-700 hover:text-blue-800 transition">
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
            <a href="<?= $baseUrl ?>privacy" class="block px-3 py-2 text-blue-800 font-semibold hover:bg-gray-50 rounded-md transition">Privacy</a>
            <a href="<?= $baseUrl ?>terms" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition">Terms</a>
            <a href="<?= $baseUrl ?>data-deletion" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition">Data Deletion</a>
        </div>
    </div>
</nav>

<!-- Header -->
<header class="gradient-hero text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-10 left-20 w-64 h-64 bg-white rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-10 right-20 w-80 h-80 bg-blue-300 rounded-full filter blur-3xl"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="centered-card fade-in-on-scroll" style="max-width: 600px;">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-700 to-blue-900 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Privacy Policy</h1>
            <p class="text-xl text-gray-600">Last updated: January 2024</p>
        </div>
    </div>
</header>

<!-- Content -->
<main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="glass-card rounded-lg shadow-sm p-8 md:p-12 fade-in-on-scroll">
        <div class="prose prose-lg max-w-none">
            <section id="introduction" class="mb-12 fade-in-on-scroll">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Introduction</h2>
                <p class="text-gray-700 mb-4">
                    Welcome to <?= $appName; ?> ("we," "our," or "us"). We are committed to protecting your privacy and ensuring you have a positive experience when using our transcription service. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our mobile application and services.
                </p>
                <p class="text-gray-700">
                    By using <?= $appName; ?>, you agree to the collection and use of information in accordance with this policy. If you do not agree with our policies and practices, please do not use our service.
                </p>
            </section>

            <section id="information-collected" class="mb-12 fade-in-on-scroll" style="transition-delay: 0.1s;">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Information We Collect</h2>
                
                <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-6">2.1 Audio Files</h3>
                <p class="text-gray-700 mb-4">
                    When you use our transcription service, you upload audio files for processing. These files are temporarily stored on our secure servers during transcription and are encrypted both in transit and at rest.
                </p>

                <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-6">2.2 Account Data</h3>
                <ul class="list-disc pl-6 text-gray-700 space-y-2 mb-4">
                    <li><strong>Registration Information:</strong> Name, email address, password (hashed), and profile information</li>
                    <li><strong>Usage Data:</strong> How you interact with our app, features used, time spent, and frequency of use</li>
                    <li><strong>Device Information:</strong> Device type, operating system, unique device identifiers, and mobile network information</li>
                    <li><strong>Log Data:</strong> IP address, browser type, access times, pages viewed, and referring URLs</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-6">2.3 Transcription Data</h3>
                <p class="text-gray-700 mb-4">
                    We store your transcriptions, summaries, keywords, and tags as part of our service. This data is associated with your account and can be accessed, edited, or deleted by you at any time.
                </p>

                <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-6">2.4 Payment Information</h3>
                <p class="text-gray-700">
                    Payment processing is handled securely through RevenueCat and third-party payment processors (Apple App Store, Google Play Store). We do not store your full payment card details. We only receive transaction confirmations and subscription status.
                </p>
            </section>

            <section id="how-we-use" class="mb-12 fade-in-on-scroll" style="transition-delay: 0.2s;">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">3. How We Use Your Information</h2>
                <p class="text-gray-700 mb-4">We use the information we collect for the following purposes:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>To provide, maintain, and improve our transcription services</li>
                    <li>To process your transactions and manage your account</li>
                    <li>To authenticate your identity and prevent fraud</li>
                    <li>To send you service-related notifications and updates</li>
                    <li>To respond to your inquiries and provide customer support</li>
                    <li>To analyze usage patterns and improve our app's functionality</li>
                    <li>To detect, prevent, and address technical issues</li>
                    <li>To comply with legal obligations and enforce our terms of service</li>
                </ul>
            </section>

            <section id="data-storage" class="mb-12 fade-in-on-scroll" style="transition-delay: 0.3s;">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Data Storage and Security</h2>
                <p class="text-gray-700 mb-4">
                    We implement industry-standard security measures to protect your information:
                </p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2 mb-4">
                    <li><strong>Encryption:</strong> All data transmitted between your device and our servers is encrypted using SSL/TLS</li>
                    <li><strong>Secure Storage:</strong> Audio files and transcriptions are stored on secure, encrypted servers with regular backups</li>
                    <li><strong>Access Controls:</strong> Limited access to personal data on a need-to-know basis with multi-factor authentication</li>
                    <li><strong>Regular Audits:</strong> We conduct regular security assessments and updates</li>
                    <li><strong>Data Retention:</strong> We retain your data only as long as necessary to provide our services or as required by law</li>
                </ul>
                <p class="text-gray-700">
                    However, no method of transmission over the internet or electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your data, we cannot guarantee absolute security.
                </p>
            </section>

            <section id="third-party" class="mb-12 fade-in-on-scroll" style="transition-delay: 0.4s;">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Third-Party Services</h2>
                <p class="text-gray-700 mb-4">We use the following third-party services that may collect or process your data:</p>
                
                <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-6">5.1 ElevenLabs API</h3>
                <p class="text-gray-700 mb-4">
                    We use ElevenLabs API for advanced speech recognition and transcription processing. Audio files are sent to ElevenLabs for transcription and are subject to their privacy policy. We ensure all data transfers are encrypted and comply with data protection regulations.
                </p>

                <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-6">5.2 RevenueCat</h3>
                <p class="text-gray-700 mb-4">
                    RevenueCat handles subscription management and payment processing. They collect payment information and subscription data. Please review RevenueCat's privacy policy for details on how they handle your data.
                </p>

                <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-6">5.3 Analytics Services</h3>
                <p class="text-gray-700">
                    We may use analytics services to understand how users interact with our app. These services collect anonymized usage data and do not identify individual users.
                </p>
            </section>

            <section id="user-rights" class="mb-12 fade-in-on-scroll" style="transition-delay: 0.5s;">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Your Rights</h2>
                <p class="text-gray-700 mb-4">You have the following rights regarding your personal information:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2 mb-4">
                    <li><strong>Access:</strong> Request access to your personal data</li>
                    <li><strong>Correction:</strong> Request correction of inaccurate or incomplete data</li>
                    <li><strong>Deletion:</strong> Request deletion of your account and associated data</li>
                    <li><strong>Portability:</strong> Request a copy of your data in a portable format</li>
                    <li><strong>Opt-Out:</strong> Unsubscribe from marketing communications (service-related messages may still be sent)</li>
                    <li><strong>Data Processing:</strong> Object to or restrict certain processing of your data</li>
                </ul>
                <p class="text-gray-700">
                    To exercise these rights, please contact us at <a href="mailto:privacy@<?= $appName; ?>" data-copy-email="privacy@<?= $appName; ?>" class="text-blue-800 hover:underline">privacy@<?= $appName; ?></a> or use our 
                    <a href="<?= $baseUrl ?>data-deletion" class="text-blue-800 hover:underline">Data Deletion Request</a> page.
                </p>
            </section>

            <section id="cookies" class="mb-12 fade-in-on-scroll" style="transition-delay: 0.6s;">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Cookies and Tracking Technologies</h2>
                <p class="text-gray-700 mb-4">
                    We use cookies and similar tracking technologies to track activity on our service and hold certain information. Cookies are files with a small amount of data which may include an anonymous unique identifier.
                </p>
                <p class="text-gray-700 mb-4">Types of cookies we use:</p>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li><strong>Essential Cookies:</strong> Required for the service to function properly</li>
                    <li><strong>Analytics Cookies:</strong> Help us understand how users interact with our service</li>
                    <li><strong>Preference Cookies:</strong> Remember your settings and preferences</li>
                </ul>
                <p class="text-gray-700 mt-4">
                    You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our service.
                </p>
            </section>

            <section id="contact" class="mb-8 fade-in-on-scroll" style="transition-delay: 0.7s;">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Contact Us</h2>
                <p class="text-gray-700 mb-4">
                    If you have any questions about this Privacy Policy or our data practices, please contact us:
                </p>
                <div class="glass-card p-6 rounded-lg">
                    <p class="text-gray-700 mb-2"><strong>Privacy Email:</strong> <a href="mailto:privacy@<?= $appName; ?>" data-copy-email="privacy@<?= $appName; ?>" class="text-blue-800 hover:underline">privacy@<?= $appName; ?></a></p>
                    <p class="text-gray-700 mb-2"><strong>Support Email:</strong> <a href="mailto:support@emmallextech.com" data-copy-email="support@emmallextech.com" class="text-blue-800 hover:underline">support@emmallextech.com</a></p>
                    <p class="text-gray-700"><strong>Data Deletion Requests:</strong> <a href="<?= $baseUrl ?>data-deletion" class="text-blue-800 hover:underline">Request Data Deletion</a></p>
                </div>
            </section>
        </div>
    </div>
</main>