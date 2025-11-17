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
     * Initialize a paystack transaction
     * 
     * @return array
     */
    private function initPaystack($email, $amount) {

        $url = "https://api.paystack.co/transaction/initialize";

        $fields = [
            'email' => $email,
            'amount' => $amount * 100
        ];

        $fields_string = http_build_query($fields);

        //open connection
        $ch = curl_init();

        $secretKey = configs('is_local') ? configs('paystack_test_secret') : configs('paystack_live_secret');
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $secretKey,
            "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $result = curl_exec($ch);

        return json_decode($result, true);
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

        $generateUrl = $this->initPaystack($this->currentUser['email'], $planInfo['price']);

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