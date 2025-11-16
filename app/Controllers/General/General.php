<?php 

namespace App\Controllers\General;

use App\Controllers\LoadController;
use App\Libraries\Routing;

class General extends LoadController {

    public function utilities() {
        $result = [];
        return Routing::success($result);
    }

    /**
     * Get all the endpoints for the current user
     * 
     * @return array
     */
    public function endpoints() {

        // Get all the methods for the current user
        $baseDir = APPPATH . 'Libraries/Validation';

        // Recursive function to scan directories
        function scanDirectory($dir, &$results) {
            $files = scandir($dir);

            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $path = $dir . DIRECTORY_SEPARATOR . $file;

                if (is_dir($path)) {
                    scanDirectory($path, $results);
                } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                    $results[] = $path;
                }
            }

        }

        // Scan the base directory for PHP files
        $files = [];
        scanDirectory($baseDir, $files);

        $endpoints = [];

        // Loop through each file and load the class
        foreach ($files as $file) {
            // Extract the class name from the file path
            $className = pathinfo($file, PATHINFO_FILENAME);

            // Assume namespace follows folder structure (e.g., App\Controllers\Subfolder\ClassName)
            $fullClassName = "App\\Libraries\\Validation\\{$className}";

            if (in_array($className, ['GeneralValidation'])) {
                continue;
            }

            $initObject = new $fullClassName();

            $clean = strtolower(str_ireplace('Validation', '', $className));

            foreach($initObject->routes as $key => $value) {
                $endpoints[$clean]["/api/{$clean}/{$key}"] = $value;
            }
        }

        return Routing::success($endpoints, 'Endpoints listed successfully');
    }

}