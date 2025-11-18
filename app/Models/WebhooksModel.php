<?php

// ==================== WebhooksModel.php ====================
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class WebhooksModel extends Model {
    
    protected $table = 'webhooks';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'event', 'payload', 'created_at', 'updated_at'
    ];


}