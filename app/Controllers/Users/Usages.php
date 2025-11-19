<?php 

namespace App\Controllers\Users;

use App\Controllers\LoadController;

class Usages extends LoadController {


    public $rawUsage = 0;

    /**
     * Check if the user record exists
     * 
     * @param int $userId
     * @param string|null $start_date
     * @param string|null $end_date
     * 
     * @return int
     */
    public function checkUsage($userId, $start_date = null, $end_date = null) {

        if(empty($start_date)) {
            $start_date = date('Y-m-d');
        }

        if(empty($end_date)) {
            $end_date = date('Y-m-d');
        }
        $dateWhere = "AND DATE(created_at) >= '{$start_date}' AND DATE(created_at) <= '{$end_date}'";

        $checkUser = $this->theDb->query("SELECT SUM(seconds_used) as total_seconds FROM users_usages WHERE user_id = ? {$dateWhere}", [$userId])->getRowArray();
        if(empty($checkUser)) {
            return 0;
        }

        return empty($checkUser['total_seconds']) ? 0 : $checkUser['total_seconds'];
    }

    /**
     * Check if the user is entitled to the service
     * 
     * @param int $userId
     * @param string $billingStartDate
     * @param int $monthLimit
     * 
     * @return bool
     */
    public function isEntitled($userId, $billingStartDate, $monthLimit = 0) {

        $checkUsage = $this->checkUsage($userId, $billingStartDate);
        if($checkUsage == 0) {
            return true;
        }

        $this->rawUsage = $checkUsage;

        if($checkUsage >= ($monthLimit * 60)) {
            return false;
        }

        return true;
    }

    /**
     * Get the files upload usage of the user
     * 
     * @param int $userId
     * @param string|null $start_date
     * @param string|null $end_date
     * 
     * @return int
     */
    public function filesUpload($userId, $start_date = null, $end_date = null) {

        if(empty($start_date)) {
            $start_date = date('Y-m-d');
        }

        if(empty($end_date)) {
            $end_date = date('Y-m-d');
        }
        $dateWhere = "AND DATE(created_at) >= '{$start_date}' AND DATE(created_at) <= '{$end_date}'";

        $checkUser = $this->theDb->query("SELECT * FROM audio_files WHERE user_id = ? {$dateWhere}", [$userId])->getResultArray();
        
        $fileSize = array_sum(array_column($checkUser, 'size'));
        $filesCount = count($checkUser);

        return [
            'fileSize' => number_to_size($fileSize),
            'rawFileZe' => $fileSize,
            'filesCount' => $filesCount,
        ];
    }

    /**
     * Get the last 30 days usage of the user
     * 
     * @param string $billingCircleStartDate
     * @param int $userId
     * 
     * @return int
     */
    public function billingCircleUsage($billingCircleStartDate, $userId, $monthLimit = 0) {

        $start_date = date('Y-m-d', strtotime($billingCircleStartDate));
        $end_date = date('Y-m-d');
        
        $recorded_seconds = $this->checkUsage($userId, $start_date, $end_date);

        $result = [
            'entitled' => ($monthLimit * 60) >= $recorded_seconds,
            'recording' => $recorded_seconds,
            'monthly_limit' => $monthLimit,
            'files' => $this->filesUpload($userId, $start_date, $end_date),
        ];

        return $result;

    }

    /**
     * Log the user's usage for the day
     * 
     * @param int $userId
     * @param int $seconds
     * 
     * @return bool
     */
    public function logUsage($userId, $seconds) {

        $check = $this->checkUsage($userId);

        if($check > 0) {
            $this->theDb->query("UPDATE users_usages SET seconds_used = (seconds_used + {$seconds}) WHERE user_id = ? AND DATE(created_at) = ?", [$userId, date('Y-m-d')]);
        }
        else {
            $this->theDb->query("INSERT INTO users_usages (user_id, seconds_used, usage_date) VALUES (?, ?, ?)", [$userId, $seconds, date('Y-m-d')]);
        }

        return true;

    }

}
?>