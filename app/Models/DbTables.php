<?php 
namespace App\Models;

class DbTables {

    public static $authTokenTable = 'user_token_auth';
    public static $userTable = 'users';
    public static $accessTable = 'access';

    public static $testimonialsTable = 'testimonials';

    public static $resourcesTable = 'resources';

    public static $webhookTable = 'webhooks';

    public static $organizationTable = 'organizations';
    public static $analyticsTable = 'analytics';
    public static $altUserTable = 'altuser';
    
    public static $dashboardTable = 'dashboard_data';
    public static $userDashboardTable = 'user_dashboard_data';
    public static $subscriptionTable = 'user_subscriptions';
    
    public static $settingsTable = 'app_settings';

    public static $paymentsTable = 'user_subscriptions_methods';
    public static $paymentsTokenTable = 'user_subscriptions_methods_token';

    /**
     * Initialize the tables
     * 
     * @return array
     */
    public static function initTables() {
        return [
            'resourcesTable', 'authTokenTable', 'userTable', 'accessTable', 'organizationTable', 'analyticsTable', 'altUserTable'
        ];
    }
}
