<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AccessModel;
use App\Models\AuthModel;
use App\Libraries\Caching;
use App\Models\ResourcesModel;

use App\Models\JurisdictionsModel;
use App\Models\DriversModel;
use App\Models\VehiclesModel;
use App\Models\RoutesModel;
use App\Models\HouseholdsModel;
use App\Models\EmergenciesModel;
use App\Models\CommunicationsModel;
use App\Models\PickupsModel;
use App\Models\ContractorsModel;

use App\Models\PaymentsModel;
use App\Models\AssembliesModel;

use App\Models\NotificationsModel;


// Traits
use App\Libraries\Traits\HasAuthorization;
class LoadController extends BaseController
{
    
    use HasAuthorization;

    protected $usersModel;
    protected $accessModel;
    protected $authModel;
    protected $accountStatus;
    protected $categoriesModel;
    protected $analyticsObject;
    protected $supportModel;
    protected $resourcesModel;

    protected $notificationsModel;
    
    protected $assembliesModel;

    public function __construct($model = [])
    {
        // initialize the models
        $this->authModel = new AuthModel();
        $this->usersModel = new UsersModel();
        
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

                // initialize additional for pickups
                if(in_array($model, ['pickups'])) {
                    $this->triggerModel(['households', 'drivers', 'contractors'], false);
                }

                // initialize additional for vehicles
                if(in_array($model, ['vehicles'])) {
                    $this->triggerModel(['drivers'], false);
                }
                
            }

        }
    }

}
