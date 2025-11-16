<?php

/**
 * Format the user response
 * 
 * @param array $user
 * @param bool $single
 * @param array $currentUser
 * @param bool $userId
 * @param string|null $search
 * 
 * @return array
 * 
 */
function formatUserResponse($user, bool $single = false, $simpleData = false) {
    if(empty($user)) return [];

    // format the user response
    foreach($user as $key => $value) {

        // if the user is an admin and the user id is the same as the current user id, skip the user
        if(empty($value)) continue;

        // format the user response
        $result[] = [
            "user_id" => $value['id'],
            "email" => $value['email'],
            "name" => $value['name'],
            "status" => $value['status'],
            "role" => $value['role'],
            "gender" => $value['gender']
        ];

        foreach(['contractor_id', 'jurisdiction_id', 'assembly_id'] as $item) {
            $result[$key][$item] = !empty($value[$item]) ? (int) $value[$item] : 0;
        }

        if(!$simpleData) {
            foreach(['username', 'two_factor_setup', 'nationality', 'date_of_birth', 'phone', 'timezone', 'last_login'] as $item) {
                $result[$key][$item] = $value[$item];
            }
        }
    }

    return $single ? ($result[0] ?? []) : ($result ?? []);
}


/**
 * Format the account response
 * 
 * @param array $account
 * 
 * @return array
 * 
 */
function formatAccountResponse($account, string $ikey = 'account') {
    
    if(empty($account)) return [];

    // format the account response
    foreach($account as $key => $value) {

        $permission = "read";
        $explode = explode(',', $value['access']);
        if(in_array('write', $explode)) $permission = "write";
        if(in_array('admin', $explode)) $permission = "admin";

        // account_name
        $account_name = ($value['account_name'] ?? ($value['user_name'] ?? null));

        $result[] = [
            "account_id" => (int) $value['account_id'],
            "{$ikey}_name" => !empty($account_name) ? $account_name : ($value['full_name'] ?? null),
            "{$ikey}_email" => ($value['account_email'] ?? ($value['user_email'] ?? $value['email'])),
            "user_id" => (int) $value['user_id'],
            "access" => $permission,
            "site_ids" => !empty($value['site_ids']) ? explode(',', $value['site_ids']) : []
        ];

    }
    return $result;
}

/**
 * Generate username from username
 *
 * @param string $email
 *
 * @return string
 */
function generateUsername($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    }
    $username = str_ireplace(["@", "_", "-", ".com", ".org", ".uk", ".co"], [""], substr($email, 0, strrpos($email, ".",)));
    return strtolower($username);
}

/**
 * Hash the password
 * 
 * @param string $password
 * 
 * @return string
 */
function hash_password($password) {
    return password_hash(md5($password), PASSWORD_DEFAULT);
}
?>
