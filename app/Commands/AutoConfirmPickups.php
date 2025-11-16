<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Controllers\Pickups\Pickups;

class AutoConfirmPickups extends BaseCommand
{
    protected $group       = 'BinGo';
    protected $name        = 'pickups:autoconfirm';
    protected $description = 'Auto-confirm pickups that have been pending for 2+ hours';

    public function run(array $params)
    {
        CLI::write('Starting auto-confirm process at ' . date('Y-m-d H:i:s'), 'yellow');
        
        try {
            $pickupsController = new Pickups();
            $result = $pickupsController->autoConfirm();
            
            CLI::write('Auto-confirm completed successfully!', 'green');
            
            if (is_array($result)) {
                CLI::write('Result: ' . json_encode($result));
            }
            
        } catch (\Exception $e) {
            CLI::error('Error: ' . $e->getMessage());
            log_message('error', 'Auto-confirm cron failed: ' . $e->getMessage());
            return EXIT_ERROR;
        }
        
        return EXIT_SUCCESS;
    }
}