<?php

// ==================== notifications_helper.php ====================

if (!function_exists('createNotification')) {
    function createNotification($userId, $type, $title, $message, $data = []) {
        $notificationsModel = new \App\Models\NotificationsModel();
        
        return $notificationsModel->createRecord([
            'user_id' => $userId,
            'notification_type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => json_encode($data),
            'sent_at' => date('Y-m-d H:i:s'),
            'delivery_channel' => 'Push',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}

if (!function_exists('sendPickupReminderNotification')) {
    function sendPickupReminderNotification($household, $pickup) {
        $message = "Your bin pickup is scheduled for tomorrow at " . ($pickup['scheduled_time'] ?? 'your usual time');
        
        return createNotification(
            $household['user_id'],
            'PickupReminder',
            'Bin Pickup Reminder',
            $message,
            ['pickup_id' => $pickup['id']]
        );
    }
}

if (!function_exists('sendDriverArrivedNotification')) {
    function sendDriverArrivedNotification($household, $pickup) {
        $message = "Your waste collector has arrived. Please confirm pickup by clicking 'GO'";
        
        return createNotification(
            $household['user_id'],
            'DriverArrived',
            'Driver Has Arrived',
            $message,
            ['pickup_id' => $pickup['id']]
        );
    }
}


if (!function_exists('sendContractorStatusNotification')) {
    /**
     * Send notification when contractor status changes
     * 
     * @param int $contractorId
     * @param string $status (approved, suspended, deactivated)
     * @param string $reason
     * @return bool
     */
    function sendContractorStatusNotification($contractorId, $status, $reason = '') {
        try {
            // Load necessary models
            $contractorsModel = model('App\Models\ContractorsModel');
            $notificationsModel = model('App\Models\NotificationsModel');
            
            // Get contractor details
            $contractor = $contractorsModel->find($contractorId);
            
            if (empty($contractor)) {
                return false;
            }

            // Prepare notification message
            $messages = [
                'approved' => 'Your contractor account has been approved. You can now start operations.',
                'suspended' => 'Your contractor account has been suspended.' . (!empty($reason) ? " Reason: {$reason}" : ''),
                'deactivated' => 'Your contractor account has been deactivated.' . (!empty($reason) ? " Reason: {$reason}" : ''),
                'reactivated' => 'Your contractor account has been reactivated. You can resume operations.',
            ];

            $message = $messages[$status] ?? "Your contractor account status has been changed to: {$status}";

            // Create notification record
            $notification = [
                'user_id' => $contractor['user_id'],
                'type' => 'contractor_status',
                'title' => 'Account Status Update',
                'message' => $message,
                'data' => json_encode([
                    'contractor_id' => $contractorId,
                    'status' => $status,
                    'reason' => $reason,
                    'timestamp' => date('Y-m-d H:i:s')
                ]),
                'read_at' => null,
                'notification_type' => 'ContractorStatus',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $notificationsModel->insert($notification);

            // Send email notification
            if (!empty($contractor['contact_email'])) {
                sendEmailNotification(
                    $contractor['contact_email'],
                    'Account Status Update - BinGo',
                    $message
                );
            }

            // Send SMS notification
            if (!empty($contractor['contact_phone'])) {
                sendSMSNotification(
                    $contractor['contact_phone'],
                    $message
                );
            }

            return true;

        } catch (\Exception $e) {
            log_message('error', 'Failed to send contractor status notification: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('sendEmailNotification')) {
    /**
     * Send email notification
     * 
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return bool
     */
    function sendEmailNotification($to, $subject, $message) {
        try {
            $email = \Config\Services::email();
            
            $email->setFrom(getenv('email.fromEmail'), getenv('email.fromName'));
            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage($message);
            
            return $email->send();
        } catch (\Exception $e) {
            log_message('error', 'Failed to send email: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('sendSMSNotification')) {
    /**
     * Send SMS notification
     * 
     * @param string $phone
     * @param string $message
     * @return bool
     */
    function sendSMSNotification($phone, $message) {
        try {
            // Implement your SMS gateway integration here
            // Example: Twilio, Africa's Talking, etc.
            
            log_message('info', "SMS sent to {$phone}: {$message}");
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Failed to send SMS: ' . $e->getMessage());
            return false;
        }
    }
}