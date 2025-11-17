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

        $history = $this->paymentsModel->listPayments($payload, $this->payload['limit'] ?? 10, $this->payload['offset'] ?? 0);
        
        return Routing::success($history);
    }

    /**
     * Verify a paystack transaction
     * 
     * @return array
     */
    public function verify() {

        $reference = $this->payload['reference'];
        $planId = $this->payload['planId'];

        $successStatuses = ['Approved', 'Successful', 'Success'];

        // check if the payment record exists
        $checkExists = $this->paymentsModel->checkExists([
            'reference' => $reference,
        ]);

        // verify the reference id generated
        if(!empty($checkExists) && in_array($checkExists['status'], $successStatuses)) {
            // payment status was successful
            $checkExists['status'] = 'success';
            return Routing::created(['data' => 'Payment already verified.', 'record' => $checkExists]);
        }

        // create a new paystack object
        $paystackObject = new Paystack();

        // verify the payment status using the reference
        $verify = $paystackObject->verifyPaystack($reference);

        if(empty($verify)) {
            return Routing::error('The payment could not be verified.');
        }

        $paymentStatus = $verify['gateway_response'];

        if(!in_array($paymentStatus, $successStatuses)) {
            return Routing::error("Payment was not successful. Status marked as: {$paymentStatus}.");
        }
        
        $payload = [
            'subscription_amount' => revenue_conversion(($verify['amount'] / 100), 'GHS', 'USD', $this->cacheObject)['revenue'],
            'customer_id' => $verify['customer']['customer_code'],
            'subscription_plan' => ucwords($planId),
        ];

        // update the subscription expiry date
        if($this->currentUser['subscription_plan'] == 'Free') {
            $payload['subscription_start_date'] = date('Y-m-d H:i:s');
            $payload['subscription_expires_at'] = date('Y-m-d H:i:s', strtotime('+1 month'));
        }

        // check if the payment record exists
        $checkExists = $this->paymentsModel->checkExists([
            'reference' => $verify['id'],
        ]);

        // update the user record
        $this->usersModel->updateRecord($this->currentUser['id'], $payload);

        // create the payment payload
        $paymentPayload = [
            'user_id' => $this->currentUser['id'],  
            'amount' => $payload['subscription_amount'], 
            'amount_ghs' => ($verify['amount'] / 100),
            'status' => 'Success',
            'created_at' => date('Y-m-d H:i:s'), 
            'updated_at' => date('Y-m-d H:i:s'),
            'reference' => $this->payload['reference'],
            'plan_id' => $planId,
            'plan_name' => ucwords($planId),
            'transaction_id' => $verify['id'],
            'last4' => $verify['authorization']['last4'],
            'customer_id' => $verify['customer']['customer_code'],
            'subscription_id' => $verify['plan'] ?? '',
            'payment_method' => $verify['authorization']['channel'], 
            'payment_bank' => $verify['authorization']['bank'], 
        ];

        if(empty($checkExists)) {
            // create the payment record
            $this->paymentsModel->createRecord($payload);
        }

        // payment status was successful
        $paymentPayload['status'] = 'success';

        return Routing::created([
            'data' => 'Payment successfully verified.', 
            'record' => $paymentPayload
        ]);
    }

    /**
     * Initialize a subscription
     * 
     * @return array
     */
    public function initialize() {

        $plan = strtoupper($this->payload['planId']);

        // setup the subscription plans
        $planInfo = subscriptionPlans()[$plan] ?? [];
        
        if(empty($planInfo)) {
            return Routing::error('Plan not found');
        }

        // current user plan
        $currentPlan = $this->currentUser['subscription_plan'];
        if(!empty($currentPlan) && (strtoupper($currentPlan) == $plan)) {
            return Routing::error('You are already subscribed to this plan.');
        }

        $planType = configs('is_local') ? 'test' : 'live';

        // create the paystack plan
        $paystackObject = new Paystack();

        // set the user email address
        $email = $this->currentUser['email'];

        // get the plan id 
        $planId = $planInfo['planInfo'][$planType]['id'];

        // generate the payment authorization url
        $generateUrl = $paystackObject->initPaystack($email, $planInfo['price'], $planId, $planType);

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