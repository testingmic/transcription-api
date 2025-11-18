<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AuthModel;
use App\Libraries\Caching;
use App\Models\AudioModel;
use App\Models\ResourcesModel;

use App\Models\PaymentsModel;
use App\Models\TranscriptionsModel;
use App\Models\TicketsModel;

use App\Models\WebhooksModel;

// Traits
use App\Libraries\Traits\HasAuthorization;
class LoadController extends BaseController
{
    
    use HasAuthorization;

    protected $usersModel;
    protected $accessModel;
    protected $authModel;
    protected $accountStatus;
    protected $analyticsObject;
    protected $supportModel;

    protected $resourcesModel;
    protected $audioModel;
    protected $paymentsModel;

    protected $ticketsModel;

    protected $transcriptionsModel;
    protected $notificationsModel;
    
    protected $webhooksModel;
    
    public function __construct($model = [])
    {
        // initialize the models
        $this->authModel = new AuthModel();
        $this->usersModel = new UsersModel();
        $this->transcriptionsModel = new TranscriptionsModel();
        $this->audioModel = new AudioModel();
        
        // initialize the cache object
        if(empty($this->cacheObject)) {
            $this->cacheObject = new Caching();
        }

        // get the last name of the class that has been called and trigger the model
        $childClass = get_called_class();
        $getLastName = explode('\\', $childClass);
        $triggeredModel = $getLastName[count($getLastName) - 1];

        $this->triggerModel(strtolower($triggeredModel));
    }

    /**
     * Trigger model
     * 
     * @param array $model
     * @return void
     */
    public function triggerModel($model, $loop = true) {
        
        // check if the model is an array
        if(function_exists('stringToArray')) {

            $models = stringToArray($model);
            
            // Define a mapping of model names to their corresponding model classes
            $modelMap = [
                'resources' => ResourcesModel::class,
                'payments' => PaymentsModel::class,
                'tickets' => TicketsModel::class,
                'webhooks' => WebhooksModel::class
            ];
            
            // Loop through the requested models and initialize them
            foreach ($models as $modelName) {
                if (isset($modelMap[$modelName])) {
                    $propertyName = $modelName . 'Model';
                    $this->{$propertyName} = !empty($this->{$propertyName}) ? $this->{$propertyName} : new $modelMap[$modelName]();
                }
            }

            // initialize additional models
            if($loop) {

                // initialize additional for audio
                if(in_array($model, ['audio'])) {
                    $this->triggerModel(['transcriptions'], false);
                }

            }

        }
    }

}
