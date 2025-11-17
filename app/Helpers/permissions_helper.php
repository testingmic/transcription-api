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
        'Admin' => [
            'users' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'profile' => true,
            ],
            'transcriptions' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
            ],
            'audio' => [
                'create' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
            ],
        ],

        /**
         * USER ROLE
         * User operations
         */
        'User' => [
            'users' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'profile' => true,
            ],
            'transcriptions' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
            ],
            'audio' => [
                'create' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
            ],
        ],


        /**
         * MODERATOR ROLE
         * Moderator operations
         */
        'Moderator' => [
            'users' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
                'profile' => true,
            ],
            'transcriptions' => [
                'create' => true,
                'update' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
            ],
            'audio' => [
                'create' => true,
                'list' => true,
                'view' => true,
                'delete' => true,
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