<?php

namespace App\Controllers\Payments;

use App\Controllers\LoadController;
use App\Libraries\Routing;

class Payments extends LoadController {

    /**
     * List payments
     * @return array
     */
    public function list() {

        $payload = [];

        if($this->isUser()) {
            $payload['user_id'] = $this->currentUser['id'];
        } 
        elseif(!empty($this->payload['user_id'])) {
            $payload['user_id'] = $this->payload['user_id'];
        }
        
        return Routing::success('Payment history retrieved successfully');
    }

    /**
     * Initialize the payments controller
     * @return void
     */
    public function initialize() {

    }

    /**
     * List payments history
     * @return array
     */
    public function history() {
        return $this->list();
    }

    /**
     * View a payment
     * @return array
     */
    public function view() {

        if(empty($this->uniqueId)) {
            return Routing::error('Payment ID is required');
        }

        $payload = ['id' => $this->uniqueId];

    }

}
?>