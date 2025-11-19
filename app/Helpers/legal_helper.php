<?php
/**
 * Get the terms of service
 * 
 * @return array
 */
function termsOfService() {

    return [
        'title' => 'Terms of Service',
        'subtitle' => 'Please read these terms carefully before using our transcription service.',
        'iconColor' => '#3B82F6',
        'iconBackground' => '#EFF6FF',
        'sections' => [
            [
                'heading' => 'Acceptance of Terms',
                'text' => 'By accessing and using Transc.io ("the Service"), you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.',
            ],
            [
                'heading' => '2. Description of Service',
                'text' => 'Transc.io is an AI-powered transcription service that converts audio files into text. The Service includes:',
                'items' => [
                  'Audio-to-text transcription using artificial intelligence (via ElevenLabs API)',
                  'Storage and management of transcriptions',
                  'Export capabilities for transcriptions in multiple formats',
                  'Cloud synchronization across devices',
                  'Additional features as described in the application',
                ],
            ],
            [
                'heading' => '3. User Accounts',
                'text' => 'To use certain features of the Service, you must create an account. You agree to:',
                'items' => [
                  'Provide accurate, current, and complete information during registration',
                  'Maintain and promptly update your account information',
                  'Maintain the security of your password and account',
                  'Accept responsibility for all activities under your account',
                  'Notify us immediately of any unauthorized use of your account',
                ],
            ],
            [
                'heading' => '4. Subscription and Payment',
                'text' => 'We offer various subscription plans with different features and usage limits. Subscription fees are billed in advance on a monthly or annual basis, as selected by you. All subscriptions are managed through RevenueCat and processed via Apple App Store or Google Play Store.',
            ],
            [
                'heading' => '5. Intellectual Property',
                'text' => 'You retain ownership of any audio files and transcriptions you upload to the Service. By uploading content, you grant us a limited, non-exclusive license to use, store, and process your content solely for the purpose of providing the Service.',
            ],
            [
                'heading' => '6. Prohibited Uses',
                'text' => 'You agree not to use the Service to:',
            ],
            [
                'heading' => '7. Limitation of Liability',
                'text' => 'TO THE MAXIMUM EXTENT PERMITTED BY LAW, TRANSC.IO SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, OR ANY LOSS OF PROFITS OR REVENUES, WHETHER INCURRED DIRECTLY OR INDIRECTLY, OR ANY LOSS OF DATA, USE, GOODWILL, OR OTHER INTANGIBLE LOSSES. Our total liability for any claims arising from or related to the Service shall not exceed the amount you paid us in the 12 months preceding the claim.',
            ],
            [
                'heading' => '8. Termination',
                'text' => 'We may terminate or suspend your account and access to the Service immediately, without prior notice, for conduct that we believe violates these Terms or is harmful to other users, us, or third parties, or for any other reason. Upon termination, your right to use the Service will immediately cease. We may delete your account and data at any time after termination.',
            ],
            [
                'heading' => '9. Dispute Resolution',
                'text' => 'These Terms shall be governed by and construed in accordance with the laws of the jurisdiction in which Transc.io operates, without regard to its conflict of law provisions. Any disputes arising from these Terms or the Service shall be resolved through binding arbitration or in the appropriate courts, as determined by applicable law.',
            ],
            [
                'heading' => '10. Contact Information',
                'text' => 'If you have any questions about these Terms, please contact us:',
                'items' => [
                  'Legal Email: legal@transc.io',
                  'Support Email: support@transc.io',
                ],
            ],
        ],
        'lastUpdated' => date('Y-m-d'),
    ];

}

function privacyPolicy() {
    return [
        'title' => 'Privacy Policy',
        'subtitle' => 'Please read this privacy policy carefully to understand how we collect, use, and protect your information.',
        'iconColor' => '#3B82F6',
        'iconBackground' => '#EFF6FF',
        'sections' => [
            [
                'heading' => '1. Introduction',
                'text' => 'Welcome to Transc.io ("we," "our," or "us"). We are committed to protecting your privacy and ensuring you have a positive experience when using our transcription service. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our mobile application and services. By using Transc.io, you agree to the collection and use of information in accordance with this policy. If you do not agree with our policies and practices, please do not use our service.',
            ],
            [
                'heading' => '2. Information We Collect',
                'text' => 'We collect several types of information to provide and improve our service:',
                'items' => [
                    'Audio Files: When you use our transcription service, you upload audio files for processing. These files are temporarily stored on our secure servers during transcription and are encrypted both in transit and at rest.',
                    'Account Data: Registration information (name, email address, password hashed, and profile information), usage data (how you interact with our app, features used, time spent, and frequency of use), device information (device type, operating system, unique device identifiers, and mobile network information), and log data (IP address, browser type, access times, pages viewed, and referring URLs).',
                    'Transcription Data: We store your transcriptions, summaries, keywords, and tags as part of our service. This data is associated with your account and can be accessed, edited, or deleted by you at any time.',
                    'Payment Information: Payment processing is handled securely through RevenueCat and third-party payment processors (Apple App Store, Google Play Store). We do not store your full payment card details. We only receive transaction confirmations and subscription status.',
                ],
            ],
            [
                'heading' => '3. How We Use Your Information',
                'text' => 'We use the information we collect for the following purposes:',
                'items' => [
                    'To provide, maintain, and improve our transcription services',
                    'To process your transactions and manage your account',
                    'To authenticate your identity and prevent fraud',
                    'To send you service-related notifications and updates',
                    'To respond to your inquiries and provide customer support',
                    'To analyze usage patterns and improve our app\'s functionality',
                    'To detect, prevent, and address technical issues',
                    'To comply with legal obligations and enforce our terms of service',
                ],
            ],
            [
                'heading' => '4. Data Storage and Security',
                'text' => 'We implement industry-standard security measures to protect your information. However, no method of transmission over the internet or electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your data, we cannot guarantee absolute security.',
                'items' => [
                    'Encryption: All data transmitted between your device and our servers is encrypted using SSL/TLS',
                    'Secure Storage: Audio files and transcriptions are stored on secure, encrypted servers with regular backups',
                    'Access Controls: Limited access to personal data on a need-to-know basis with multi-factor authentication',
                    'Regular Audits: We conduct regular security assessments and updates',
                    'Data Retention: We retain your data only as long as necessary to provide our services or as required by law',
                ],
            ],
            [
                'heading' => '5. Third-Party Services',
                'text' => 'We use the following third-party services that may collect or process your data:',
                'items' => [
                    'ElevenLabs API: We use ElevenLabs API for advanced speech recognition and transcription processing. Audio files are sent to ElevenLabs for transcription and are subject to their privacy policy. We ensure all data transfers are encrypted and comply with data protection regulations.',
                    'RevenueCat: RevenueCat handles subscription management and payment processing. They collect payment information and subscription data. Please review RevenueCat\'s privacy policy for details on how they handle your data.',
                    'Analytics Services: We may use analytics services to understand how users interact with our app. These services collect anonymized usage data and do not identify individual users.',
                ],
            ],
            [
                'heading' => '6. Your Rights',
                'text' => 'You have the following rights regarding your personal information. To exercise these rights, please contact us at privacy@transc.io or use our Data Deletion Request page:',
                'items' => [
                    'Access: Request access to your personal data',
                    'Correction: Request correction of inaccurate or incomplete data',
                    'Deletion: Request deletion of your account and associated data',
                    'Portability: Request a copy of your data in a portable format',
                    'Opt-Out: Unsubscribe from marketing communications (service-related messages may still be sent)',
                    'Data Processing: Object to or restrict certain processing of your data',
                ],
            ],
            [
                'heading' => '7. Cookies and Tracking Technologies',
                'text' => 'We use cookies and similar tracking technologies to track activity on our service and hold certain information. Cookies are files with a small amount of data which may include an anonymous unique identifier. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our service.',
                'items' => [
                    'Essential Cookies: Required for the service to function properly',
                    'Analytics Cookies: Help us understand how users interact with our service',
                    'Preference Cookies: Remember your settings and preferences',
                ],
            ],
            [
                'heading' => '8. Contact Us',
                'text' => 'If you have any questions about this Privacy Policy or our data practices, please contact us:',
                'items' => [
                    'Privacy Email: privacy@transc.io',
                    'Support Email: support@transc.io',
                    'Data Deletion Requests: Request Data Deletion',
                ],
            ],
        ],
        'lastUpdated' => date('Y-m-d'),
    ];
}

?>