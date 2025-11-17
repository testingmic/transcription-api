<?php

namespace App\Controllers\Payments;

use App\Controllers\LoadController;
use App\Libraries\Routing;

class Paystack extends LoadController {

    private $account_id = [
        'test' => 'ACCT_jo9tc3oh08x38tr',
        'live' => 'ACCT_6zahsx8cbky415y'
    ];
    
    private $urlPath = [
        'initialize' => "https://api.paystack.co/transaction/initialize",
        'verify' => "https://api.paystack.co/transaction/verify/",
    ];

    /**
     * This method makes the request to paystack
     * 
     * @param string $method
     * @param string $fields_string
     * 
     * @return array
     */
    private function makeRequest($path, $method = 'GET', $fields_string = []) {

        //open connection
        $ch = curl_init();

        $secretKey = configs('is_local') ? configs('paystack_test_secret') : configs('paystack_live_secret');
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $this->urlPath[$path]);
        curl_setopt($ch,CURLOPT_POST, $method == 'POST');
        if(!empty($fields_string)) {
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        }
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
     * Initialize a paystack transaction
     * 
     * @param string $email
     * @param float $amount
     * @param string $planId
     * @param string $type
     * 
     * @return array
     */
    public function initPaystack($email, $amount, $planId, $type = 'test') {

        $fields = [
            'email' => $email,
            'plan' => $planId,
            'currency' => 'GHS',
            'amount' => $amount * 100,
            'subaccount' => $this->account_id[$type],
        ];

        $fields_string = http_build_query($fields);

        return $this->makeRequest( 'initialize', 'POST', $fields_string);
    }

    /**
     * Verify a paystack transaction
     * 
     * @param string $reference
     * 
     * @return array
     */
    public function verifyPaystack($reference) {

        $this->urlPath['verify'] = $this->urlPath['verify'] . "{$reference}";

        $verify = $this->makeRequest('verify');

        if(empty($verify['status'])) {
            return false;
        }

        return $verify['data'];
    }

}

?>