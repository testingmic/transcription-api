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
        'title'=> 'Terms of Service',
        'subtitle' => 'Please read these terms carefully before using our transcription service.',
        'iconColor' => '#3B82F6',
        'iconBackground' => '#EFF6FF',
        'sections' => []
    ];
}

?>