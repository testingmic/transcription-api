<?php

namespace App\Controllers\Subscriptions;

use App\Controllers\LoadController;
use App\Libraries\Routing;

class Subscriptions extends LoadController {

    /**
     * List Subscriptions
     * 
     * @return array
     */
    public function plans() {
        
       $plans = subscriptionPlans();
       return Routing::success($plans);

    }

}