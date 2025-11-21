<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-12" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold text-white mb-4 bg-gradient-to-r from-blue-700 to-blue-900 bg-clip-text text-transparent"><?= $appName; ?></h3>
                <p class="text-sm">AI-powered transcription service for accurate and fast audio-to-text conversion.</p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Product</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= $baseUrl ?>#features" class="hover:text-white transition focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">Features</a></li>
                    <li><a href="<?= $baseUrl ?>#how-it-works" class="hover:text-white transition focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">How It Works</a></li>
                    <li><a href="<?= $baseUrl ?>pricing" class="hover:text-white transition focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">Pricing</a></li>
                    <li><a href="<?= $baseUrl ?>#faq" class="hover:text-white transition focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Legal</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= $baseUrl ?>privacy" class="hover:text-white transition focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">Privacy Policy</a></li>
                    <li><a href="<?= $baseUrl ?>terms" class="hover:text-white transition focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">Terms & Conditions</a></li>
                    <li><a href="<?= $baseUrl ?>data-deletion" class="hover:text-white transition focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">Data Deletion</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Support</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= $baseUrl ?>contact" class="hover:text-white transition focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">Contact Us</a></li>
                    <li><a href="mailto:support@verbastream.com" data-copy-email="support@verbastream.com" class="hover:text-white transition cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">support@verbastream.com</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
            <p>&copy; 2025 <?= $appName; ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="<?= $baseUrl ?>assets/js/main.js"></script>
</body>
</html>