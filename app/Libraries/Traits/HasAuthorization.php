<?php

namespace App\Libraries\Traits;

use App\Libraries\Routing;

/**
 * HasAuthorization Trait
 * 
 * Provides role-based authorization checks for controllers
 */
trait HasAuthorization {

    public $theCurrentUser;

    /**
     * Set the current user
     * 
     * @param array $user
     * @return void
     */
    protected function setCurrentUser($user) {
        $this->theCurrentUser = $user;
    }

    /**
     * Get the current user
     * 
     * @return array
     */
    protected function getCurrentUser() {
        // reset the current user from the request
        $this->setCurrentUserFromRequest();

        // return the current user
        return $this->theCurrentUser;
    }

    /**
     * Reset the current user from the request
     * 
     * @return void
     */
    protected function setCurrentUserFromRequest() {
        // if the current user is not set, set it to the current user
        if(!empty($this->currentUser) && empty($this->theCurrentUser)) {
            $this->setCurrentUser($this->currentUser);
        }
    }

    /**
     * Load permissions configuration
     * 
     * @return array
     */
    protected function loadPermissions() {
        static $permissions = null;
        
        if ($permissions === null) {
            $permissions = getPermissions();
        }
        
        return $permissions;
    }

    /**
     * Check if current user has permission for action
     * 
     * @param string $module
     * @param string $action
     * @param array|null $user (optional, uses $this->theCurrentUser if not provided)
     * @return bool
     */
    protected function hasPermission($module, $action, $user = null) {

        // reset the current user from the request
        $this->setCurrentUserFromRequest();

        $user = $user ?? ($this->theCurrentUser ?? []);
        
        if (empty($user)) {
            return false;
        }
        
        $userRole = strtolower($user['role'] ?? 'household');
        
        // Admin has all permissions
        $permissions = $this->loadPermissions();
        
        if (!isset($permissions[$userRole])) {
            return false;
        }
        
        if (!isset($permissions[$userRole][$module])) {
            return false;
        }
        
        return $permissions[$userRole][$module][$action] ?? false;
    }

    /**
     * Check permission and return error if unauthorized
     * 
     * @param string $module
     * @param string $action
     * @return array|bool Returns error array if unauthorized, true if authorized
     */
    protected function authorizeAction($module, $action) {
        if (!$this->hasPermission($module, $action)) {
            return Routing::denied(
                "You do not have permission to perform this action."
            );
        }
        
        return true;
    }

    /**
     * Check multiple permissions (user needs ALL)
     * 
     * @param array $checks Array of ['module' => 'action'] pairs
     * @return bool
     */
    protected function hasAllPermissions($checks) {
        foreach ($checks as $module => $action) {
            if (!$this->hasPermission($module, $action)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Check multiple permissions (user needs ANY)
     * 
     * @param array $checks Array of ['module' => 'action'] pairs
     * @return bool
     */
    protected function hasAnyPermission($checks) {
        foreach ($checks as $module => $action) {
            if ($this->hasPermission($module, $action)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get all permissions for current user
     * 
     * @return array
     */
    protected function getUserPermissions() {
        $user = $this->theCurrentUser;
        
        if (empty($user)) {
            return [];
        }
        
        return $user['permissions'] ?? [];
    }

    /**
     * Get module permissions for current user
     * 
     * @param string $module
     * @return array
     */
    protected function getModulePermissions($module) {
        $userPermissions = $this->getUserPermissions();
        return $userPermissions[$module] ?? [];
    }

    /**
     * Check if current user can access module
     * 
     * @param string $module
     * @return bool
     */
    protected function canAccessModule($module) {
        $userPermissions = $this->getUserPermissions();
        return isset($userPermissions[$module]);
    }

    /**
     * Get all modules current user can access
     * 
     * @return array
     */
    protected function getAccessibleModules() {
        $userPermissions = $this->getUserPermissions();
        return array_keys($userPermissions);
    }

    /**
     * Check if user owns resource
     * 
     * @param int $resourceUserId
     * @param int|null $currentUserId
     * @return bool
     */
    protected function ownsResource($resourceUserId, $currentUserId = null) {

        // reset the current user from the request
        $this->setCurrentUserFromRequest();

        // get the current user id
        $currentUserId = !empty($currentUserId) ? $currentUserId : ($this->theCurrentUser['id'] ?? null);

        // if the current user id is empty, return false
        if (empty($currentUserId)) {
            return false;
        }

        if($this->isAdmin()) {
            return true;
        }

        // return true if the resource user id is the same as the current user id
        return (int)$resourceUserId === (int)$currentUserId;
    }

    /**
     * Check if user is admin
     * 
     * @return bool
     */
    protected function isAdmin() {
        $user = $this->theCurrentUser ?? [];
        return strtolower($user['role'] ?? '') === 'admin';
    }

    /**
     * Check if user is contractor
     * 
     * @return bool
     */
    protected function isContractor() {
        $user = $this->theCurrentUser ?? [];
        return strtolower($user['role'] ?? '') === 'contractor';
    }

    /**
     * Check if user is assembly
     * 
     * @return bool
     */
    protected function isAssembly() {
        $user = $this->theCurrentUser ?? [];
        return strtolower($user['role'] ?? '') === 'assembly';
    }

    /**
     * Check if user is driver
     * 
     * @return bool
     */
    protected function isDriver() {
        $user = $this->theCurrentUser ?? [];
        return strtolower($user['role'] ?? '') === 'driver';
    }

    /**
     * Check if user is household
     * 
     * @return bool
     */
    protected function isHousehold() {
        $user = $this->theCurrentUser ?? [];
        return strtolower($user['role'] ?? '') === 'household';
    }

    /**
     * Check if user is tricycle
     * 
     * @return bool
     */
    protected function isTricycle() {
        $user = $this->theCurrentUser ?? [];
        return strtolower($user['role'] ?? '') === 'tricycle';
    }

    /**
     * Check if user is admin or contractor
     * 
     * @return bool
     */
    protected function adminContractor() {
        return $this->isAdmin() || $this->isContractor();
    }

    /**
     * Check if user is admin, assembly, or contractor
     * 
     * @return bool
     */
    protected function isPrivileged() {
        return $this->isAdmin() || $this->isAssembly() || $this->isContractor();
    }

    /**
     * Check if user is restricted
     * 
     * @return bool
     */
    protected function isRestricted() {
        return $this->isHousehold() || $this->isDriver() || $this->isTricycle();
    }

    /**
     * Require specific role
     * 
     * @param string|array $roles Single role or array of roles
     * @return array|bool Returns error array if unauthorized, true if authorized
     */
    protected function requireRole($roles) {
        $user = $this->theCurrentUser ?? [];
        $userRole = strtolower($user['role'] ?? '');
        
        $roles = is_array($roles) ? $roles : [$roles];
        $roles = array_map('strtolower', $roles);
        
        if (!in_array($userRole, $roles)) {
            return Routing::denied(
                "This action requires one of the following roles: " . implode(', ', $roles)
            );
        }
        
        return true;
    }

    /**
     * Check contractor ownership
     * 
     * @param int $contractorId
     * @return bool
     */
    protected function ownsContractor($contractorId) {
        if ($this->isAdmin()) {
            return true;
        }
        
        $user = $this->theCurrentUser ?? [];
        $userContractorId = $user['contractor_id'] ?? null;
        
        return $userContractorId && (int)$userContractorId === (int)$contractorId;
    }

    /**
     * Check assembly jurisdiction
     * 
     * @param int $jurisdictionId
     * @return bool
     */
    protected function hasJurisdiction($jurisdictionId) {
        if ($this->isAdmin()) {
            return true;
        }
        
        $user = $this->theCurrentUser ?? [];
        $userAssemblyId = $user['assembly_id'] ?? null;
        
        if (!$userAssemblyId) {
            return false;
        }
        
        // Load jurisdiction and check if it belongs to user's assembly
        // This would require database query - implement based on your needs
        return true; // Placeholder
    }

    /**
     * Filter data based on user role and permissions
     * 
     * @param array $data
     * @param array $sensitiveFields Fields to filter
     * @return array
     */
    protected function filterSensitiveData($data, $sensitiveFields = []) {
        if ($this->isAdmin()) {
            return $data;
        }
        
        $defaultSensitiveFields = [
            'password',
            'twofactor_secret',
            'reset_code',
            'api_key',
            'secret_key'
        ];
        
        $fieldsToRemove = array_merge($defaultSensitiveFields, $sensitiveFields);
        
        foreach ($fieldsToRemove as $field) {
            if (isset($data[$field])) {
                unset($data[$field]);
            }
        }
        
        return $data;
    }

    /**
     * Log authorization attempt
     * 
     * @param string $module
     * @param string $action
     * @param bool $granted
     * @return void
     */
    protected function logAuthorizationAttempt($module, $action, $granted) {
        $user = $this->theCurrentUser ?? [];
        
        $logData = [
            'user_id' => $user['id'] ?? null,
            'user_type' => $user['role'] ?? 'unknown',
            'module' => $module,
            'action' => $action,
            'granted' => $granted,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        // Log to database or file
        log_message('info', 'Authorization: ' . json_encode($logData));
    }
}