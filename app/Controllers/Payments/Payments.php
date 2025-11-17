<?php

namespace App\Controllers\Payments;

use App\Controllers\LoadController;
use App\Libraries\Routing;
use App\Controllers\Payments\Paystack;

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
     * Verify a paystack transaction
     * 
     * @return array
     */
    public function verify() {

        $reference = $this->payload['reference'];

        $paystackObject = new Paystack();

        $verify = $paystackObject->verifyPaystack($reference);

        return Routing::success($verify);
    }

    /**
     * Initialize a subscription
     * 
     * @return array
     */
    public function initialize() {

        $plan = strtoupper($this->payload['planId']);

        $planInfo = subscriptionPlans()[$plan] ?? [];
        
        if(empty($planInfo)) {
            return Routing::error('Plan not found');
        }

        $paystackObject = new Paystack();

        $generateUrl = $paystackObject->initPaystack($this->currentUser['email'], $planInfo['price']);

        if(!isset($generateUrl['data']['authorization_url'])) {
            return Routing::error('Error encountered while generating the payment URL.');
        }

        unset($planInfo['planInfo']);
        
        return Routing::success([
            'plans' => $planInfo,
            'authorization_url' => $generateUrl['data']['authorization_url'],
        ]);
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