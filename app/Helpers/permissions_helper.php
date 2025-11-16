<?php

/**
 * BinGo Waste Management - Role-Based Permissions
 * 
 * User Roles:
 * - admin: Full system access
 * - assembly: Municipal assembly oversight
 * - contractor: Waste management company
 * - driver: Pickup driver
 * - household: Waste generator
 * - tricycle: Tricycle waste collector
 */
function getPermissions() {

    return [
        /**
         * ADMIN ROLE
         * Full access to all system resources
         */
        'admin' => [
            'users' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'profile' => true,
            ],
            'jurisdictions' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'populate' => true,
                'households' => true,
                'statistics' => true,
                'contractors' => true,
                'optimize_route' => true,
            ],
            'assemblies' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'dashboard' => true,
                'dashboard' => true,
                'expected_collections' => true,
                'realtime_monitoring' => true,
                'collections_by_contractor' => true,
                'missed_pickups_by_contractor' => true,
                'service_coverage' => true,
                'response_time_analysis' => true,
                'compliance_metrics' => true,
            ],
            'contractors' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'drivers' => true,
                'delete' => true,
                'approve' => true,
                'suspend' => true,
                'dashboard' => true,
                'jurisdictions' => true,
                'assign_jurisdiction' => true,
                'unassign_jurisdiction' => true,
            ],
            'households' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'bin_ready' => true,
                'confirm_pickup' => true,
                'cancel_pickup' => true,
                'pickups' => true,
                'payments' => true,
                'assign_contractor' => true,
                'assign_driver' => true,
                'unassign_contractor' => true,
                'unassign_driver' => true,
            ],
            'drivers' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'jurisdictions' => true,
                'assign_jurisdiction' => true,
                'unassign_jurisdiction' => true,
                'performance' => true,
                'update_location' => true,
            ],
            'emergencies' => [
                'list' => true,
                'view' => true,
                'create' => true,
                'update' => true,
                'resolve' => true,
                'delete' => true,
            ],
            'vehicles' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'assigned_drivers' => true,
                'assign_driver' => true,
                'unassign_all_drivers' => true,
                'unassign_driver' => true, // to be removed
                'add_maintenance' => true, // to be removed
                'maintenance_history' => true,
                'report_fault' => true, // to be removed
                'get_reported_faults' => true,
            ],
            'routes' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'optimize' => true,
                'assign_driver' => true,
            ],
            'pickups' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'confirm' => true,
                'delete' => true,
                'driver_arrived' => true,
                'mark_missed' => true,
                'statistics' => true,
            ],
            'payments' => [
                'list' => true,
                'view' => true,
                'verify' => true,
                'refund' => true,
                'statistics' => true,
            ],
            'reports' => [
                'pickup_summary' => true,
                'revenue' => true,
                'driver_performance' => true,
                'compliance' => true,
                'missed_pickups' => true,
                'export' => true,
            ],
            'analytics' => [
                'dashboard' => true,
                'pickups' => true,
                'revenue' => true,
                'performance_trends' => true,
                'geographic_distribution' => true,
                'all_metrics' => true,
            ],
        ],


        /**
         * ASSEMBLY ROLE
         * Municipal assembly oversight and monitoring
         */
        'assembly' => [
            'users' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'profile' => true,
            ],
            'jurisdictions' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'optimize_route' => true,
                'statistics' => true,
            ],
            'contractors' => [
                'list' => true,
                'view' => true,
                'drivers' => true,
                'approve' => true,
                'suspend' => true,
                'jurisdictions' => true,
                'assign_jurisdiction' => true,
                'unassign_jurisdiction' => true,
                'efficiency' => true,
            ],
            'households' => [
                'list' => true,
                'view' => true,
                'pickups' => true,
                'payments' => true,
                'assign_contractor' => true,
                'assign_driver' => true,
                'unassign_contractor' => true,
                'unassign_driver' => true,
            ],
            'emergencies' => [
                'list' => true,
                'view' => true,
                'create' => true,
                'update' => true,
                'resolve' => true,
                'delete' => true,
            ],
            'drivers' => [
                'list' => true,
                'view' => true,
                'jurisdictions' => true,
                'performance' => true,
            ],
            'pickups' => [
                'list' => true,
                'view' => true,
                'statistics' => true,
            ],
            'payments' => [
                'list' => true,
                'view' => true,
                'statistics' => true,
            ],
            'vehicles' => [
                'view' => true,
                'list' => true,
                'get_reported_faults' => true,
            ],
            'reports' => [
                'pickup_summary' => true,
                'compliance' => true,
                'missed_pickups' => true,
                'contractor_comparison' => true,
                'tricycle_backup' => true,
                'export' => true,
            ],
            'analytics' => [
                'dashboard' => true,
                'pickups' => true,
                'performance_trends' => true,
                'geographic_distribution' => true,
                'compliance_metrics' => true,
                'realtime_monitoring' => true,
            ],
            'assemblies' => [
                'dashboard' => true,
                'expected_collections' => true,
                'realtime_monitoring' => true,
                'collections_by_contractor' => true,
                'missed_pickups_by_contractor' => true,
                'service_coverage' => true,
                'response_time_analysis' => true,
                'compliance_metrics' => true,
            ],
        ],


        /**
         * CONTRACTOR ROLE
         * Waste management company operations
         */
        'contractor' => [
            'users' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'profile' => true,
            ],
            'households' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'pickups' => true,
                'payments' => true,
            ],
            'emergencies' => [
                'list' => true,
                'view' => true,
                'create' => true,
                'update' => true,
                'resolve' => true,
                'delete' => true,
            ],
            'drivers' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'update_location' => true,
                'jurisdictions' => true,
                'assign_jurisdiction' => true,
                'unassign_jurisdiction' => true,
                'assign_route' => true,
                'performance' => true,
                'earnings' => true,
            ],
            'vehicles' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'assigned_drivers' => true,
                'assign_driver' => true,
                'unassign_driver' => true,
                'unassign_all_drivers' => true,
                'add_maintenance' => true,
                'maintenance_history' => true,
                'report_fault' => true,
                'get_reported_faults' => true,
            ],
            'routes' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'add_households' => true,
                'remove_household' => true,
                'optimize' => true,
                'assign_driver' => true,
                'generate_for_date' => true,
                'performance' => true,
            ],
            'pickups' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'driver_arrived' => true,
                'confirm' => true,
                'mark_missed' => true,
                'statistics' => true,
            ],
            'payments' => [
                'list' => true,
                'view' => true,
                'statistics' => true,
            ],
            'reports' => [
                'pickup_summary' => true,
                'revenue' => true,
                'driver_performance' => true,
                'missed_pickups' => true,
                'households' => true,
                'payments' => true,
                'export' => true,
                'daily_summary' => true,
                'weekly_performance' => true,
            ],
            'analytics' => [
                'dashboard' => true,
                'pickups' => true,
                'revenue' => true,
                'performance_trends' => true,
                'efficiency' => true,
                'operational' => true,
                'financial' => true,
            ],
            'contractors' => [
                'view' => true,
                'dashboard' => true,
                'jurisdictions' => true,
                'revenue' => true,
                'report_emergency' => true,
            ],
            'jurisdictions' => [
                'list' => true,
                'view' => true,
                'optimize_route' => true,
                'statistics' => true,
            ],
        ],


        /**
         * DRIVER ROLE
         * Pickup driver operations
         */
        'driver' => [
            'users' => [
                'update' => true,
                'list' => true,
                'view' => true,
                'profile' => true,
            ],
            'households' => [
                'list' => true,
                'view' => true,
                'pickups' => true,
                'payments' => true,
            ],
            'pickups' => [
                'list' => true,
                'view' => true,
                'update' => true,
                'initiate' => true,
                'mark_missed' => true,
                'driver_arrived' => true,
                'today_pickups' => true,
            ],
            'routes' => [
                'list' => true,
                'view' => true,
            ],
            'emergencies' => [
                'list' => true,
                'view' => true,
                'create' => true,
                'update' => true,
                'resolve' => true,
                'delete' => true,
            ],
            'drivers' => [
                'view' => true,
                'today_route' => true,
                'update_location' => true,
                'performance' => true,
                'earnings' => true,
                'jurisdictions' => true,
                'report_emergency' => true,
            ],
            'vehicles' => [
                'view' => true,
                'list' => true,
                'report_fault' => true,
            ],
            'payments' => [
                'list' => true,
                'view' => true,
            ],
            'contractors' => [
                'view' => true,
                'jurisdictions' => true,
            ],
            'jurisdictions' => [
                'optimize_route' => true,
                'list' => true,
                'view' => true,
            ],
        ],


        /**
         * TRICYCLE ROLE
         * Tricycle waste collector (backup service)
         */
        'tricycle' => [
            'users' => [
                'update' => true,
                'list' => true,
                'view' => true,
                'profile' => true,
            ],
            'pickups' => [
                'list' => true,
                'view' => true,
                'update' => true,
                'initiate' => true,
                'confirm' => true,
                'mark_missed' => true,
                'driver_arrived' => true,
                'today_pickups' => true,
            ],
            'households' => [
                'list' => true,
                'view' => true,
                'pickups' => true,
                'payments' => true,
            ],
            'payments' => [
                'list' => true,
                'view' => true,
            ],
            'emergencies' => [
                'list' => true,
                'view' => true,
                'create' => true,
                'update' => true,
                'resolve' => true,
                'delete' => true,
            ],
            'drivers' => [
                'view' => true,
                'update_location' => true,
                'earnings' => true,
                'update_location' => true,
                'report_emergency' => true,
            ],
            'contractors' => [
                'view' => true,
                'jurisdictions' => true,
            ],
            'jurisdictions' => [
                'list' => true,
                'view' => true,
                'optimize_route' => true,
            ],
        ],


        /**
         * HOUSEHOLD ROLE
         * Waste generator operations
         */
        'household' => [
            'users' => [
                'update' => true,
                'list' => true,
                'view' => true,
                'create' => true,
                'delete' => true,
                'profile' => true,
            ],
            'emergencies' => [
                'list' => true,
                'view' => true,
                'create' => true,
                'update' => true,
                'resolve' => true,
                'delete' => true,
            ],
            'households' => [
                'view' => true,
                'update' => true,
                'bin_ready' => true,
                'confirm_pickup' => true,
                'cancel_pickup' => true,
                'pickups' => true,
                'payments' => true,
            ],
            'pickups' => [
                'create' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'confirm' => true,
            ],
            'payments' => [
                'list' => true,
                'view' => true,
                'initiate' => true,
                'verify' => true,
                'receipt' => true,
            ],
            'contractors' => [
                'view' => true,
                'jurisdictions' => true,
            ],
            'drivers' => [
                'view' => true,
            ],
            'jurisdictions' => [
                'optimize_route' => true,
                'list' => true,
                'view' => true,
            ],
        ],


    ];

}

/**
 * Permission Helper Functions
 */

/**
 * Check if a user has permission for a specific action
 * 
 * @param string $userRole
 * @param string $module
 * @param string $action
 * @return bool
 */
function hasPermission($userRole, $module, $action) {
    $permissions = getPermissions();
    
    if (!isset($permissions[$userRole])) {
        return false;
    }
    
    if (!isset($permissions[$userRole][$module])) {
        return false;
    }
    
    return $permissions[$userRole][$module][$action] ?? false;
}

/**
 * Get all permissions for a user role
 * 
 * @param string $userRole
 * @return array
 */
function getUserPermissions($userRole) {
    $permissions = getPermissions();
    return $permissions[$userRole] ?? [];
}

/**
 * Get module permissions for a user
 * 
 * @param string $userRole
 * @param string $module
 * @return array
 */
function getModulePermissions($userRole, $module) {
    $permissions = getPermissions();
    
    if (!isset($permissions[$userRole])) {
        return [];
    }
    
    return $permissions[$userRole][$module] ?? [];
}

/**
 * Check if user can perform any action in module
 * 
 * @param string $userRole
 * @param string $module
 * @return bool
 */
function canAccessModule($userRole, $module) {
    $permissions = getPermissions();
    
    if (!isset($permissions[$userRole])) {
        return false;
    }
    
    return isset($permissions[$userRole][$module]);
}

/**
 * Get all modules a user can access
 * 
 * @param string $userRole
 * @return array
 */
function getAccessibleModules($userRole) {
    $permissions = getPermissions();
    
    if (!isset($permissions[$userRole])) {
        return [];
    }
    
    return array_keys($permissions[$userRole]);
}