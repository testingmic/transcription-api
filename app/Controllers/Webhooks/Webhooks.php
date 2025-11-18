<?php

namespace App\Controllers\Webhooks;

use App\Controllers\LoadController;
use App\Libraries\Routing;
class Webhooks extends LoadController {

    /**
     * Verify the webhook
     * 
     * @param string $input
     * @param string $env
     * 
     * @return bool
     */
    public function verify($input, $env = 'test') {

        // check if the signature is set
        if(!isset($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'])) {
            return false;
        }

        // get the secret
        $secretKey = $env == 'live' ? configs('paystack_live_secret') : configs('paystack_test_secret');

        // validate event do all at once to avoid timing attack
        if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, $secretKey)) {
            return false;
        }

        return true;
    }

    /**
     * Handle the production webhook
     * 
     * @return array
     */
    public function live() {

        $verify = $this->verify(($this->payload['input'] ?? ''), 'live');
        if(!$verify) {
            return Routing::error('Invalid webhook signature');
        }

    }

    /**
     * Handle the test webhook
     * 
     * @return array
     */
    public function test() {

        $verify = $this->verify($this->payload['input'] ?? '');
        if(!$verify) {
            return Routing::error('Invalid webhook signature');
        }
        
    }

}