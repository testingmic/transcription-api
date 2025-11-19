<?php 

namespace App\Controllers\Users;

use App\Controllers\LoadController;
use App\Libraries\Routing;
use App\Controllers\Users\Usages;

class Users extends LoadController {

    public $softDelete = false;

    /**
     * List users
     * 
     * @return array
     */
    public function list() {

        // set the default data
        $data = [];

        // get the user ids
        $userIds = $this->payload['user_ids'] ?? [];

        // if the current user is a student, get the user ids
        if($this->isUser()) {
            $userIds = [$this->currentUser['user_id']];
            $data['role'] = ['User'];
        }

        // get the users
        $users = $this->usersModel->findUsers(
            $this->payload['limit'] ?? $this->defaultLimit, 
            $this->payload['offset'] ?? 0,
            $this->payload['search'] ?? null,
            stringToArray($this->payload['status'] ?? 'Active'),
            stringToArray($userIds),
            $data
        );

        // return the success message
        return Routing::success(formatUserResponse($users));
    }

    /**
     * View a user
     * 
     * @return array
     */
    public function view() {

        // if the current user is a user, get the user ids
        if($this->isUser()) {
            $this->payload['user_id'] = $this->currentUser['user_id'];
        }

        // check if the user id is set
        $users = $this->usersModel->findById($this->payload['user_id']);

        if(empty($users)) {
            return Routing::notFound();
        }

        $users['usage'] = (new Usages())->billingCircleUsage(
            $users['billing_circle_start_date'], 
            $users['id'], 
            $users['monthly_minutes_limit'] ?? 0
        );

        return Routing::success(formatUserResponse([$users], true));
    }

    /**
     * Get the subscription of the current user
     * 
     * @return array
     */
    public function subscription() {
        return $this->profile();
    }

    /**
     * Get the profile of the current user
     * 
     * @return array
     */
    public function profile() {

        // get the user id
        $userId = $this->currentUser['id'];

        $this->payload['user_id'] = $userId;

        currencyLookup($this->cacheObject);

        // get the user
        $data = $this->view()['data'];

        $plans = subscriptionPlans();

        foreach($plans as $key => $plan) {
            if($data['subscription']['plan'] == $plan['name']) {
                $plans[$key]['currentPlan'] = true;
            } else {
                $plans[$key]['currentPlan'] = false;
            }
            $plans[$key]['price'] = revenue_conversion($plan['price'], 'GHS', 'USD', $this->cacheObject)['revenue'];
            $plans[$key]['planInfo'] = [];
        }

        // get the subscription plans
        $data['plans'] = $plans;

        return Routing::success($data);
    }

    /**
     * Get the profile of the current user
     * 
     * @return array
     */
    public function me() {
        return $this->profile();
    }

    /**
     * Detect if the user is on an iOS mobile or web
     * 
     * @return array
     */
    public function detectIosMobileOrWeb() {

        $request = service('request');
        
        $userAgent = $request->getUserAgent();

        $isAndroid = $userAgent->isMobile('android');
        $isIos = $userAgent->isMobile('iphone');

        $getPlatform = $userAgent->getPlatform();
        $getMobile = $userAgent->getMobile();

        return [
            'device' => $isAndroid ? 'Android' : ($isIos ? 'iOS' : 'Web'),
            'platform' => $getPlatform,
            'mobile' => $getMobile
        ];
    }

    /**
     * Create a new user
     * 
     * @return array
     */
    public function create() {

        // Check if email already exists
        $confirmEmail = $this->usersModel->findByEmail($this->payload['email']);
        
        // Check if email already exists
        if ($confirmEmail) {
            return Routing::error('There is already an existing account with the same email address.');
        }

        // hash the password
        $hashPassword = hash_password($this->payload['password']);

        // set the password
        $this->submittedPayload['password'] = $hashPassword;
        $this->submittedPayload['role'] = ucwords($this->submittedPayload['role'] ?? 'User');

        // set the username
        $this->submittedPayload['username'] = generateUsername($this->payload['email']);

        // remove the password confirm
        unset($this->submittedPayload['confirmPassword']);

        $this->submittedPayload['user_device_model'] = $this->detectIosMobileOrWeb()['device'];
        $this->submittedPayload['billing_circle_start_date'] = date('Y-m-d');

        // create the user
        $userId = $this->usersModel->createRecord($this->submittedPayload);
        if(!$userId) {
            return Routing::error('Failed to create user');
        }

        // set the user id
        $this->payload['user_id'] = $userId;

        return Routing::created([
            'data' => 'The user has been created successfully', 
            'record' => (new \App\Controllers\Auth\Auth())->login($this->payload['email'], $this->payload['password'])['data']
        ]);

    }

    /**
     * Update a user
     * 
     * @return array
     */
    public function update() {

        // user id
        $userId = $this->currentUser['user_id'];
        
        // check if the user id is set
        $users = $this->usersModel->findById($userId);

        // if the user is not found, return not found
        if(empty($users)) {
            return Routing::notFound();
        }

        // remove the user id
        unset($this->submittedPayload['user_id']);

        // check if the email is set
        if(!empty($this->submittedPayload['email'])) {
            $confirmEmail = $this->usersModel->findByEmail($this->submittedPayload['email']);
            if ($confirmEmail) {
                return Routing::error('Email already exists');
            }
        }

        // remove the user type, two factor setup and two factor secret
        foreach(['user_type', 'two_factor_setup', 'twofactor_secret', 'date_registered', 'status'] as $item) {
            if(isset($this->submittedPayload[$item])) {
                unset($this->submittedPayload[$item]);
            }
        }

        // check if the password is set
        if(!empty($this->submittedPayload['password'])) {
            $hashPassword = hash_password($this->submittedPayload['password']);
            $this->submittedPayload['password'] = $hashPassword;
        }

        foreach(['social_links'] as $item) {
            if(isset($this->submittedPayload[$item])) {
                $this->submittedPayload[$item] = json_encode($this->submittedPayload[$item]);
            }
        }

        if(!empty($users['preferences']) && !empty($this->submittedPayload['preferences'])) {
            $existingPreferences = json_decode($users['preferences'], true);
            foreach($this->submittedPayload['preferences'] as $key => $value) {
                $existingPreferences[$key] = $value;
            }
            $this->submittedPayload['preferences'] = json_encode($existingPreferences);
        }

        // update the user information
        $this->usersModel->updateRecord($this->payload['user_id'], $this->submittedPayload);

        // return the success message
        return Routing::updated([
            'data' => 'The user has been updated successfully', 
            'record' => $this->view()['data']
        ]);
    }

    /**
     * Deactivate a user
     * 
     * @return array
     */
    public function deactivate() {
        
        $this->softDelete = true;

        return $this->delete();
    }

    /**
     * Delete a user
     * 
     * @return array
     */
    public function delete() {

        // check if the user id is set
        $users = $this->usersModel->findById($this->payload['user_id']);

        // if the user is not found, return not found
        if(empty($users)) {
            return Routing::notFound();
        }

        // delete the user
        $status = $this->softDelete ? 'Inactive' : 'Deleted';
        $this->usersModel->updateRecord($this->payload['user_id'], ['status' => $status]);
        
        // log the count
        $this->analyticsObject->logCount($users['user_type'], 'decrement');

        // return the success message
        return Routing::success('The user has been deleted successfully');
    }

    /**
     * Reactivate a user
     * 
     * @return array
     */
    public function reactivate() {

        // check if the user id is set
        $users = $this->usersModel->findById($this->payload['user_id'], ['Deleted', 'Inactive']);

        // if the user is not found, return not found
        if(empty($users)) {
            return Routing::notFound();
        }

        // delete the user
        $this->usersModel->updateRecord($this->payload['user_id'], ['status' => 'Active']);
        
        // return the success message
        return Routing::success('The user has been reactivated successfully');
    }

    /**
     * Get user analytics
     * 
     * @return array
     */
    public function analytics() {
        try {
            // Build filters from request
            $filters = [];
            
            if(!empty($this->payload['start_date'])) {
                $filters['start_date'] = $this->payload['start_date'];
            }
            
            if(!empty($this->payload['end_date'])) {
                $filters['end_date'] = $this->payload['end_date'];
            }

            if(!empty($this->payload['period'])) {
                $filters['period'] = $this->payload['period'];
            }

            if($this->isUser()) {
                $filters['user_id'] = $this->currentUser['id'];
            }

            // Get user analytics data
            $analyticsData = $this->usersModel->getUserAnalytics($filters);

            return Routing::success($analyticsData);

        } catch (\Exception $e) {
            log_message('error', 'User Analytics Controller Error: ' . $e->getMessage());
            return Routing::error('Failed to retrieve user analytics');
        }
    }

}

?>