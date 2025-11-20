
<!-- Navigation -->
<nav id="navbar" class="bg-white/80 backdrop-blur-lg sticky top-0 z-50 border-b border-gray-200/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="<?= $baseUrl ?>" class="text-2xl font-bold bg-gradient-to-r from-blue-700 to-blue-900 bg-clip-text text-transparent">
                    Transc.io
                </a>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="<?= $baseUrl ?>" class="text-gray-700 hover:text-blue-800 transition font-medium">Home</a>
                <a href="<?= $baseUrl ?>privacy" class="text-gray-700 hover:text-blue-800 transition font-medium">Privacy</a>
                <a href="<?= $baseUrl ?>terms" class="text-gray-700 hover:text-blue-800 transition font-medium">Terms</a>
                <a href="<?= $baseUrl ?>data-deletion" class="text-blue-800 font-semibold">Data Deletion</a>
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
            <a href="<?= $baseUrl ?>privacy" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition">Privacy</a>
            <a href="<?= $baseUrl ?>terms" class="block px-3 py-2 text-gray-700 hover:text-blue-800 hover:bg-gray-50 rounded-md transition">Terms</a>
            <a href="<?= $baseUrl ?>data-deletion" class="block px-3 py-2 text-blue-800 font-semibold hover:bg-gray-50 rounded-md transition">Data Deletion</a>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Data Deletion Request</h1>
            <p class="text-xl text-gray-600">
                Request to permanently delete your account and all associated data
            </p>
        </div>
    </div>
</header>

<!-- Content -->
<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Warning Box -->
    <div class="bg-yellow-50 border-l-4 border-blue-800 p-6 mb-8 rounded-lg fade-in-on-scroll">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-800" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Important: This action cannot be undone</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Deleting your account will permanently remove:</p>
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li>All your audio files and transcriptions</li>
                        <li>Your account information and profile data</li>
                        <li>Your subscription and payment history</li>
                        <li>All preferences and settings</li>
                    </ul>
                    <p class="mt-3 font-semibold">This process is irreversible. Please ensure you have exported any data you wish to keep before proceeding.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-card rounded-lg shadow-sm p-8 md:p-12 fade-in-on-scroll" style="transition-delay: 0.2s;">
        <form id="deletion-form" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required
                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent outline-none transition-all"
                    placeholder="your.email@example.com"
                >
                <p class="mt-2 text-sm text-gray-500">Enter the email address associated with your account</p>
            </div>

            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                    Reason for Deletion (Optional)
                </label>
                <select 
                    id="reason" 
                    name="reason"
                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-800 focus:border-transparent outline-none transition-all"
                >
                    <option value="">Select a reason...</option>
                    <option value="no-longer-needed">No longer need the service</option>
                    <option value="privacy-concerns">Privacy concerns</option>
                    <option value="found-alternative">Found an alternative service</option>
                    <option value="too-expensive">Too expensive</option>
                    <option value="technical-issues">Technical issues</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label for="comments" class="block text-sm font-medium text-gray-700 mb-2">
                    Additional Comments (Optional)
                </label>
                <textarea 
                    id="comments" 
                    name="comments" 
                    rows="4"
                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent outline-none transition-all resize-none"
                    placeholder="Please let us know if there's anything we could have done better..."
                ></textarea>
            </div>

            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input 
                        id="confirm-deletion" 
                        name="confirm-deletion" 
                        type="checkbox" 
                        required
                        class="h-4 w-4 text-blue-800 focus:ring-blue-800 border-gray-300 rounded"
                    >
                </div>
                <div class="ml-3 text-sm">
                    <label for="confirm-deletion" class="font-medium text-gray-700">
                        I understand that this action is permanent and cannot be undone
                        <span class="text-red-500">*</span>
                    </label>
                </div>
            </div>

            <div>
                <button 
                    type="submit"
                    class="btn-submit w-full gradient-primary text-white px-6 py-4 rounded-lg font-semibold text-lg relative z-10"
                >
                    Submit Deletion Request
                </button>
            </div>
        </form>

        <!-- Success Message (hidden by default) -->
        <div id="success-message" class="hidden success-message">
            <div class="bg-green-50 border-l-4 border-blue-800 p-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-800" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Request Submitted Successfully</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>We have received your data deletion request. Our team will process it within 30 days. You will receive a confirmation email once your account and data have been permanently deleted.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Section -->
    <div class="mt-8 glass-card p-6 rounded-lg fade-in-on-scroll" style="transition-delay: 0.4s;">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">What happens after you submit?</h3>
        <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
            <li>You will receive an email confirmation of your request</li>
            <li>Our team will verify your identity and account ownership</li>
            <li>Your account will be scheduled for deletion</li>
            <li>All your data will be permanently removed within 30 days</li>
            <li>You will receive a final confirmation email once deletion is complete</li>
        </ol>
    </div>

    <!-- Alternative Options -->
    <div class="mt-8 glass-card p-8 rounded-lg fade-in-on-scroll" style="transition-delay: 0.6s;">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Before you go...</h3>
        <p class="text-gray-700 mb-4">
            If you're experiencing issues or have concerns, we'd love to help! Consider these alternatives:
        </p>
        <ul class="space-y-3">
            <li class="flex items-start">
                <svg class="h-5 w-5 text-blue-800 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <strong class="text-gray-900">Contact Support:</strong>
                    <p class="text-gray-600 text-sm">Email us at <a href="mailto:support@emmallextech.com" data-copy-email="support@emmallextech.com" class="text-blue-800 hover:underline">support@emmallextech.com</a> - we're here to help!</p>
                </div>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-blue-800 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <strong class="text-gray-900">Export Your Data:</strong>
                    <p class="text-gray-600 text-sm">Download all your transcriptions before deletion from your account settings</p>
                </div>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-blue-800 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <strong class="text-gray-900">Pause Your Subscription:</strong>
                    <p class="text-gray-600 text-sm">Consider pausing instead of deleting - you can always come back later</p>
                </div>
            </li>
        </ul>
    </div>
</main>

<!-- Floating Voice Chat Widget -->
<div class="floating-widget">
    <div class="widget-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
        </svg>
    </div>
    <div class="widget-content">
        <span>VOICE CHAT</span>
        <div class="flex items-center gap-1 ml-2">
            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 60 30'%3E%3Crect width='60' height='30' fill='%23B22234'/%3E%3Cpath d='M0 3.46h60M0 7.69h60M0 11.92h60M0 16.15h60M0 20.38h60M0 24.61h60' stroke='%23fff' stroke-width='2.31'/%3E%3Crect width='24' height='16.15' fill='%23003F87'/%3E%3Cpath d='M0 0l6.92 5.38L0 10.77z' fill='%23fff'/%3E%3C/svg%3E" alt="US" class="w-4 h-3 rounded-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
    <div class="widget-attribution">Powered by Transc.io</div>
</div>