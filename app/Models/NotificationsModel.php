<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class NotificationsModel extends Model {

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'type',
        'title',
        'message',
        'read',
        'sent_at',
        'delivery_channel',
        'created_at',
        'updated_at',
        'metadata',
    ];

    public function __construct() {
        parent::__construct();
        
        foreach(DbTables::initTables() as $key) {
            if (property_exists($this, $key)) {
                $this->{$key} = DbTables::${$key};
            }
        }
    }

    /**
     * List notifications
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array|bool
     */
    public function listNotifications($filters = [], $limit = null, $offset = 0) {
        try {
            $query = $this->select('notifications.*')
                ->orderBy('created_at', 'DESC');

            foreach($filters as $key => $value) {
                if(!empty($value) || $value === '0' || $value === 0) {
                    if(is_array($value)) {
                        $query->whereIn($key, $value);
                    } else {
                        $query->where($key, $value);
                    }
                }
            }

            // Get total count before pagination
            $totalQuery = clone $query;
            $total = $totalQuery->countAllResults(false);

            // Get unread count
            $unreadQuery = clone $query;
            $unreadCount = $unreadQuery->where('read', 'false')->countAllResults(false);

            // Apply pagination
            if($limit !== null) {
                $query->limit($limit, $offset * $limit);
            }

            $notifications = $query->get()->getResultArray();

            // Process notifications to add action_url and action_text from metadata
            foreach($notifications as &$notification) {
                $notification = $this->formatNotification($notification);
            }

            return [
                'data' => $notifications,
                'total' => $total,
                'unread_count' => $unreadCount,
                'page' => $offset + 1,
                'limit' => $limit ?? $total
            ];
        } catch(DatabaseException $e) {
            log_message('error', 'Notifications List Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a notification
     * @param int|string $id
     * @return array|bool
     */
    public function getNotification($id) {
        try {
            $notification = $this->find($id);
            if($notification) {
                return $this->formatNotification($notification);
            }
            return false;
        } catch(DatabaseException $e) {
            log_message('error', 'Notification Get Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create a notification
     * @param array $data
     * @return int|bool
     */
    public function createRecord($data = []) {
        try {
            // Set defaults
            if(empty($data['type'])) {
                $data['type'] = 'info';
            }
            if(empty($data['delivery_channel'])) {
                $data['delivery_channel'] = 'Push';
            }
            if(empty($data['created_at'])) {
                $data['created_at'] = date('Y-m-d H:i:s');
            }
            if(empty($data['updated_at'])) {
                $data['updated_at'] = date('Y-m-d H:i:s');
            }
            if(empty($data['sent_at'])) {
                $data['sent_at'] = date('Y-m-d H:i:s');
            }
            if(isset($data['metadata']) && is_array($data['metadata'])) {
                $data['metadata'] = json_encode($data['metadata']);
            }

            $this->insert($data);
            return $this->insertID();
        } catch(DatabaseException $e) {
            log_message('error', 'Notification Create Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a notification
     * @param int|string $id
     * @param array $data
     * @return int|bool
     */
    public function updateRecord($id, $data = []) {
        try {
            if(isset($data['metadata']) && is_array($data['metadata'])) {
                $data['metadata'] = json_encode($data['metadata']);
            }
            if(!isset($data['updated_at'])) {
                $data['updated_at'] = date('Y-m-d H:i:s');
            }
            $this->update($id, $data);
            return $this->affectedRows();
        } catch(DatabaseException $e) {
            log_message('error', 'Notification Update Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if a notification exists
     * @param array $filters
     * @return array|bool
     */
    public function checkExists($filters = []) {
        try {
            $notification = $this->where($filters)->first();
            if($notification) {
                return $this->formatNotification($notification);
            }
            return false;
        } catch(DatabaseException $e) {
            log_message('error', 'Notification Exists Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a notification
     * @param int|string $id
     * @return bool
     */
    public function deleteRecord($id) {
        try {
            $this->delete($id);
            return $this->affectedRows() > 0;
        } catch(DatabaseException $e) {
            log_message('error', 'Notification Delete Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark notification as read
     * @param int|string $id
     * @return int|bool
     */
    public function markAsRead($id) {
        try {
            return $this->updateRecord($id, [
                'read' => 'true',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } catch(DatabaseException $e) {
            log_message('error', 'Notification Mark Read Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark all notifications as read for a user
     * @param int $userId
     * @return int|bool
     */
    public function markAllAsRead($userId) {
        try {
            $this->where('user_id', $userId)
                 ->where('read', 'false')
                 ->set([
                     'read' => 'true',
                     'updated_at' => date('Y-m-d H:i:s')
                 ])
                 ->update();
            return $this->affectedRows();
        } catch(DatabaseException $e) {
            log_message('error', 'Notifications Mark All Read Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format notification with action_url and action_text from metadata
     * @param array $notification
     * @return array
     */
    private function formatNotification($notification) {
        // Parse metadata if it's a JSON string
        $metadata = $notification['metadata'] ?? null;
        if(is_string($metadata) && !empty($metadata)) {
            $metadata = json_decode($metadata, true);
        }
        if(!is_array($metadata)) {
            $metadata = [];
        }

        // Extract action_url and action_text from metadata
        $actionUrl = $metadata['action_url'] ?? null;
        $actionText = $metadata['action_text'] ?? null;

        // If not in metadata, try to derive from type
        if(empty($actionUrl)) {
            switch($notification['type'] ?? '') {
                case 'transcription':
                    $transcriptionId = $metadata['transcription_id'] ?? null;
                    if($transcriptionId) {
                        $actionUrl = "/transcriptions/{$transcriptionId}";
                        $actionText = "View Transcription";
                    }
                    break;
                case 'subscription':
                    $actionUrl = "/subscription";
                    $actionText = "View Subscription";
                    break;
            }
        }

        // Convert read to boolean for response
        $read = $notification['read'] ?? 'false';
        $readBool = $read == 'true' ? true : false;

        return [
            'id' => $notification['id'],
            'user_id' => $notification['user_id'] ?? null,
            'title' => html_entity_decode($notification['title'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'message' => html_entity_decode($notification['message'] ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'type' => $notification['type'] ?? 'info',
            'read' => $readBool,
            'created_at' => $notification['created_at'] ?? null,
            'updated_at' => $notification['updated_at'] ?? null,
            'sent_at' => $notification['sent_at'] ?? null,
            'delivery_channel' => $notification['delivery_channel'] ?? 'Push',
            'action_url' => $actionUrl,
            'action_text' => $actionText,
            'metadata' => $metadata
        ];
    }
}

