<?php

namespace App\Controllers\Payments;

use App\Controllers\LoadController;
use App\Libraries\Routing;

class Paystack extends LoadController {

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
     * 
     * @return array
     */
    public function initPaystack($email, $amount) {

        $fields = [
            'email' => $email,
            'amount' => $amount * 100
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
            return Routing::error('The payment could not be verified.');
        }

        return $verify['data'];
    }

}

?>