<?php

// ==================== Notifications.php ====================
namespace App\Controllers\Notifications;

use App\Controllers\LoadController;
use App\Libraries\Routing;
use App\Models\NotificationsModel;

class Notifications extends LoadController {

    /**
     * List notifications
     * 
     * @return array
     */
    public function list() {
        $payload = [];

        // If user is authenticated, filter by their user_id
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        } 
        // Admin/Moderator can filter by user_id if provided
        elseif(!empty($this->payload['user_id'])) {
            $payload['user_id'] = $this->payload['user_id'];
        }

        // Add type filter if provided
        if(!empty($this->payload['type'])) {
            $payload['type'] = $this->payload['type'];
        }

        // Add read filter if provided
        if(!empty($this->payload['read'])) {
            $readValue = $this->payload['read'];
            $payload['read'] = ($readValue === 'true' || $readValue === true || $readValue === '1' || $readValue === 1) ? 'true' : 'false';
        }

        $limit = $this->payload['limit'] ?? 20;
        $offset =  $this->payload['offset'] ?? 0;

        $notifications = $this->notificationsModel->listNotifications($payload, $limit, $offset);
        
        if($notifications === false) {
            return Routing::error('Failed to retrieve notifications.');
        }

        Routing::$pagination = [
            'total' => $notifications['total'],
            'unread_count' => $notifications['unread_count'],
            'page' => $notifications['page'],
            'limit' => $notifications['total']
        ];
        
        return Routing::success($notifications['data']);
    }

    /**
     * View a notification
     * 
     * @return array
     */
    public function view() {
        if(empty($this->uniqueId)) {
            return Routing::error('Notification ID is required');
        }

        $payload = ['id' => $this->uniqueId];

        // If user is authenticated, ensure they can only view their own notifications
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        $notification = $this->notificationsModel->checkExists($payload);
        if(empty($notification)) {
            return Routing::notFound('Notification');
        }

        return Routing::success($notification);

    }

    /**
     * Create a notification
     * 
     * @return array
     */
    public function create() {

        $data = [
            'user_id' => $this->payload['user_id'],
            'type' => $this->payload['type'] ?? 'info',
            'title' => $this->payload['title'],
            'read' => $this->payload['read'] ?? '0',
            'message' => $this->payload['message'],
            'delivery_channel' => $this->payload['delivery_channel'] ?? 'Push',
        ];

        // Handle metadata if provided
        if(!empty($this->payload['metadata'])) {
            $data['metadata'] = is_array($this->payload['metadata']) 
                ? $this->payload['metadata'] 
                : json_decode($this->payload['metadata'], true);
        }

        $notificationId = $this->notificationsModel->createRecord($data);
        
        if($notificationId === false) {
            return Routing::error('Failed to create notification.');
        }

        $notification = $this->notificationsModel->getNotification($notificationId);
        
        return Routing::created([
            'data' => 'Notification created successfully.',
            'record' => $notification
        ]);
    }

    /**
     * Update a notification
     * 
     * @return array
     */
    public function update() {
        if(empty($this->uniqueId)) {
            return Routing::error('Notification ID is required');
        }

        $payload = ['id' => $this->uniqueId];

        // If user is authenticated, ensure they can only update their own notifications
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        // Check if notification exists
        $notification = $this->notificationsModel->checkExists($payload);
        if(empty($notification)) {
            return Routing::notFound('Notification');
        }

        // Prepare update data
        $updateData = [];
        
        if(!empty($this->payload['type'])) {
            $updateData['type'] = $this->payload['type'];
        }
        if(!empty($this->payload['title'])) {
            $updateData['title'] = $this->payload['title'];
        }
        if(!empty($this->payload['message'])) {
            $updateData['message'] = $this->payload['message'];
        }
        if(isset($this->payload['read'])) {
            $readValue = $this->payload['read'];
            $updateData['read'] = ($readValue === 'true' || $readValue === true || $readValue === '1' || $readValue === 1) ? 'true' : 'false';
        }
        if(!empty($this->payload['delivery_channel'])) {
            $updateData['delivery_channel'] = $this->payload['delivery_channel'];
        }
        if(isset($this->payload['metadata'])) {
            $updateData['metadata'] = is_array($this->payload['metadata']) 
                ? $this->payload['metadata'] 
                : json_decode($this->payload['metadata'], true);
        }

        if(empty($updateData)) {
            return Routing::error('No fields to update.');
        }

        $updated = $this->notificationsModel->updateRecord($this->uniqueId, $updateData);
        
        if($updated === false) {
            return Routing::error('Failed to update notification.');
        }

        $updatedNotification = $this->notificationsModel->getNotification($this->uniqueId);
        
        return Routing::updated('Notification updated successfully.', $updatedNotification);
    }

    /**
     * Delete a notification
     * 
     * @return array
     */
    public function delete() {
        if(empty($this->uniqueId)) {
            return Routing::error('Notification ID is required');
        }

        $payload = ['id' => $this->uniqueId];

        // If user is authenticated, ensure they can only delete their own notifications
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        // Check if notification exists
        $notification = $this->notificationsModel->checkExists($payload);
        if(empty($notification)) {
            return Routing::notFound('Notification');
        }

        $deleted = $this->notificationsModel->deleteRecord($this->uniqueId);
        
        if($deleted === false) {
            return Routing::error('Failed to delete notification.');
        }

        return Routing::deleted();
    }

    /**
     * Mark a notification as read
     * 
     * @return array
     */
    public function read() {
        
        if(empty($this->payload['notification_id'])) {
            return Routing::error('Notification ID is required');
        }

        $payload = ['id' => $this->payload['notification_id']];

        // If user is authenticated, ensure they can only mark their own notifications as read
        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        }

        // Check if notification exists
        $notification = $this->notificationsModel->checkExists($payload);
        if(empty($notification)) {
            return Routing::notFound('Notification');
        }

        $updated = $this->notificationsModel->markAsRead($this->payload['notification_id']);
        
        if($updated === false) {
            return Routing::error('Failed to mark notification as read.');
        }

        $updatedNotification = $this->notificationsModel->getNotification($this->payload['notification_id']);
        
        return Routing::updated('Notification marked as read.', $updatedNotification);
    }

    /**
     * Mark all notifications as read
     * 
     * @return array
     */
    public function readall() {
        // Get user_id - must be authenticated user or provided in payload
        $userId = null;
        
        if($this->isUser()) {
            $userId = $this->currentUser['id'];
        } elseif(!empty($this->payload['user_id'])) {
            $userId = $this->payload['user_id'];
        } else {
            return Routing::error('User ID is required.');
        }

        $updated = $this->notificationsModel->markAllAsRead($userId);
        
        if($updated === false) {
            return Routing::error('Failed to mark all notifications as read.');
        }

        return Routing::updated("Successfully marked {$updated} notification(s) as read.");
    }

}