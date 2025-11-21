<!-- Navigation -->
<nav id="navbar" class="bg-white/80 backdrop-blur-lg sticky top-0 z-50 border-b border-gray-200/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="<?= $baseUrl ?>" class="flex items-center gap-3 text-2xl font-bold" style="color: #1db3ff;" aria-label="Verba Stream Home">
                    <img src="<?= $baseUrl ?>assets/images/logo.png" alt="Verba Stream Logo" class="h-15 w-auto">
                    <span><?= $appName; ?></span>
                </a>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="<?= $baseUrl ?>" class="text-gray-700 hover:text-blue-800 transition font-medium">Home</a>
                <a href="<?= $baseUrl ?>#features" class="text-gray-700 hover:text-blue-800 transition font-medium">Features</a>
                <a href="<?= $baseUrl ?>pricing" class="text-blue-800 font-semibold" aria-current="page">Pricing</a>
                <a href="<?= $baseUrl ?>contact" class="text-gray-700 hover:text-blue-800 transition font-medium">Contact</a>
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
            <a href="<?= $baseUrl ?>pricing" class="block px-3 py-2 text-blue-800 font-semibold hover:bg-gray-50 rounded-md transition">Pricing</a>
            <a href="<?= $baseUrl ?>contact" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition">Contact</a>
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
            <li class="text-gray-900 font-medium" aria-current="page">Pricing</li>
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
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Choose Your Plan</h1>
        <p class="text-xl text-white/90 max-w-2xl mx-auto">
            Transparent pricing with no hidden fees. Start free and upgrade when you need more.
        </p>
    </div>
</header>

<!-- Pricing Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <?php 
            $plans = $subscriptionPlans;
            $planIndex = 0;
            foreach ($plans as $planKey => $plan): 
                $isPopular = $planKey === 'PRO';
                $planIndex++;
            ?>
            <div class="glass-card p-8 rounded-xl fade-in-on-scroll <?= $isPopular ? 'ring-2 ring-blue-800 transform scale-105' : '' ?>" style="transition-delay: <?= ($planIndex - 1) * 0.1 ?>s;">
                <?php if ($isPopular): ?>
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-gradient-to-r from-blue-700 to-blue-900 text-white px-4 py-1 rounded-full text-sm font-semibold">Most Popular</span>
                </div>
                <?php endif; ?>
                
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($plan['name']) ?></h3>
                    <div class="mb-4">
                        <span class="text-5xl font-bold text-gray-900">$<?= number_format($plan['price'], 2) ?></span>
                        <?php if ($plan['price'] > 0): ?>
                        <span class="text-gray-600">/month</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($plan['price'] === 0): ?>
                    <p class="text-gray-600 text-sm">Perfect for trying out</p>
                    <?php endif; ?>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700"><?= number_format($plan['minutesLimit']) ?> minutes/month</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Up to <?= $plan['maxFileSize'] ?>MB file size</span>
                    </li>
                    <?php if ($plan['features']['speakerDiarization']): ?>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Speaker Diarization</span>
                    </li>
                    <?php endif; ?>
                    <?php if ($plan['features']['priorityProcessing']): ?>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Priority Processing</span>
                    </li>
                    <?php endif; ?>
                    <?php if ($plan['features']['cloudStorage']): ?>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Cloud Storage</span>
                    </li>
                    <?php endif; ?>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-700">Export: <?= implode(', ', $plan['features']['exportFormats']) ?></span>
                    </li>
                </ul>

                <?php if ($plan['price'] === 0): ?>
                <a href="<?= $baseUrl ?>" class="btn-primary w-full gradient-primary text-white px-6 py-3 rounded-lg font-semibold text-center block hover:bg-blue-900 transition shadow-lg">
                    Get Started Free
                </a>
                <?php else: ?>
                <a href="<?= isset($plan['planInfo']['live']['paylink']) ? $plan['planInfo']['live']['paylink'] : '#' ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn-primary w-full gradient-primary text-white px-6 py-3 rounded-lg font-semibold text-center block hover:bg-blue-900 transition shadow-lg"
                   aria-label="Subscribe to <?= htmlspecialchars($plan['name']) ?> plan">
                    Subscribe Now
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Feature Comparison Table -->
        <div class="glass-card rounded-xl p-8 fade-in-on-scroll" style="transition-delay: 0.4s;">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Feature Comparison</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="pb-4 text-gray-900 font-semibold">Feature</th>
                            <?php foreach ($plans as $plan): ?>
                            <th class="pb-4 text-center text-gray-900 font-semibold"><?= htmlspecialchars($plan['name']) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="py-4 text-gray-700">Monthly Minutes</td>
                            <?php foreach ($plans as $plan): ?>
                            <td class="py-4 text-center"><?= number_format($plan['minutesLimit']) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="py-4 text-gray-700">Max File Size</td>
                            <?php foreach ($plans as $plan): ?>
                            <td class="py-4 text-center"><?= $plan['maxFileSize'] ?>MB</td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="py-4 text-gray-700">Speaker Diarization</td>
                            <?php foreach ($plans as $plan): ?>
                            <td class="py-4 text-center">
                                <?php if ($plan['features']['speakerDiarization']): ?>
                                <svg class="w-5 h-5 text-green-600 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <?php else: ?>
                                <span class="text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="py-4 text-gray-700">Priority Processing</td>
                            <?php foreach ($plans as $plan): ?>
                            <td class="py-4 text-center">
                                <?php if ($plan['features']['priorityProcessing']): ?>
                                <svg class="w-5 h-5 text-green-600 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <?php else: ?>
                                <span class="text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="py-4 text-gray-700">Cloud Storage</td>
                            <?php foreach ($plans as $plan): ?>
                            <td class="py-4 text-center">
                                <?php if ($plan['features']['cloudStorage']): ?>
                                <svg class="w-5 h-5 text-green-600 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <?php else: ?>
                                <span class="text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="py-4 text-gray-700">Export Formats</td>
                            <?php foreach ($plans as $plan): ?>
                            <td class="py-4 text-center text-sm text-gray-600"><?= implode(', ', $plan['features']['exportFormats']) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="mt-12 text-center fade-in-on-scroll" style="transition-delay: 0.5s;">
            <p class="text-gray-600 mb-4">Trusted by thousands of users</p>
            <div class="flex flex-wrap justify-center items-center gap-8">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-700 font-medium">SSL Encrypted</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-700 font-medium">GDPR Compliant</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-700 font-medium">Secure Payments</span>
                </div>
            </div>
        </div>
    </div>
</section>


