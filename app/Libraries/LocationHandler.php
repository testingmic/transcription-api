<?php

namespace App\Libraries;

use App\Models\LocationsModel;
use Exception;

/**
 * LocationHandler Class
 * 
 * Handles geolocation detection, reverse geocoding using Google Maps API,
 * and caching location data in database for Ghana-specific addresses
 */
class LocationHandler
{
    protected $locationsModel;
    protected $googleApiKey;
    protected $cacheEnabled = true;
    protected $defaultAccuracy = 10; // meters
    
    // Ghana region codes for GPS address generation
    protected $ghanaRegionCodes = [
        'Greater Accra' => 'GA',
        'Ashanti' => 'AH',
        'Western' => 'WP',
        'Central' => 'CP',
        'Eastern' => 'EP',
        'Volta' => 'VR',
        'Northern' => 'NP',
        'Upper East' => 'UE',
        'Upper West' => 'UW',
        'Brong Ahafo' => 'BA',
        'Ahafo' => 'AF',
        'Bono' => 'BO',
        'Bono East' => 'BE',
        'Oti' => 'OT',
        'Savannah' => 'SV',
        'North East' => 'NE',
        'Western North' => 'WN'
    ];
    
    public function __construct()
    {
        $this->locationsModel = new LocationsModel();
        $this->googleApiKey = getenv('GOOGLE_MAPS_API_KEY');
        
        if (empty($this->googleApiKey)) {
            log_message('error', 'Google Maps API Key not configured');
        }
    }
    
    /**
     * Main method to get complete location information
     * 
     * @param float|null $latitude
     * @param float|null $longitude
     * @param array $options Additional options (force_refresh, accuracy, etc.)
     * @return array|false Location data or false on failure
     */
    public function getLocationInfo($latitude = null, $longitude = null, array $options = [])
    {
        try {
            // If coordinates not provided, try to get from IP geolocation
            if (empty($latitude) || empty($longitude)) {
                $randomType = rand(0, 1) ? 'ip-api' : 'geoapi';
                $ipLocation = $this->getLocationFromIP(null, $randomType);
                if (empty($ipLocation)) {
                    return $this->errorResponse('Unable to detect location. Please provide coordinates.');
                }
                $latitude = $ipLocation['latitude'];
                $longitude = $ipLocation['longitude'];
            }
            
            // Validate coordinates
            if (!$this->validateCoordinates($latitude, $longitude)) {
                return $this->errorResponse('Invalid coordinates provided');
            }
            
            // Generate location hash for caching
            $locationHash = $this->generateLocationHash($latitude, $longitude);
            
            // Check if we should force refresh or if cache is disabled
            $forceRefresh = $options['force_refresh'] ?? false;
           
            // Check cache first (unless force refresh)
            if ($this->cacheEnabled && !$forceRefresh) {
                $cachedLocation = $this->locationsModel->findByHash($locationHash);
                if (!empty($cachedLocation)) {
                    return $this->successResponse($cachedLocation, true);
                }
            }
            
            // Fetch from Google API
            $locationData = $this->fetchFromGoogleAPI($latitude, $longitude);
            
            if (empty($locationData)) {
                return $this->errorResponse('Failed to fetch location data from Google API');
            }
            
            // Parse and structure the location data
            $structuredData = $this->structureLocationData($locationData, $latitude, $longitude, $locationHash);
            
            // Save to database
            $savedLocation = $this->saveLocation($structuredData);
            
            if ($savedLocation) {
                return $this->successResponse($structuredData, false);
            }
            
            return $this->errorResponse('Failed to save location data');
            
        } catch (Exception $e) {
            log_message('error', 'LocationHandler Error: ' . $e->getMessage());
            return $this->errorResponse('An error occurred while processing location: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate unique hash for location (12 chars for lat + 12 chars for lng)
     * 
     * @param float $latitude
     * @param float $longitude
     * @return string 24-character hash
     */
    protected function generateLocationHash($latitude, $longitude)
    {
        $latHash = substr(md5((string)$latitude), 0, 12);
        $lngHash = substr(md5((string)$longitude), 0, 12);
        
        return $latHash . $lngHash;
    }
    
    /**
     * Validate coordinates are within valid ranges
     * 
     * @param float $latitude
     * @param float $longitude
     * @return bool
     */
    protected function validateCoordinates($latitude, $longitude)
    {
        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            return false;
        }
        
        // Ghana approximate bounds: Lat 4.5° to 11.5°, Lng -3.5° to 1.5°
        // Allow slightly wider range for border areas
        $lat = (float)$latitude;
        $lng = (float)$longitude;
        
        if ($lat < 4.0 || $lat > 12.0) {
            log_message('warning', "Latitude {$lat} outside Ghana bounds");
        }
        
        if ($lng < -4.0 || $lng > 2.0) {
            log_message('warning', "Longitude {$lng} outside Ghana bounds");
        }
        
        // General validation
        return $lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180;
    }
    
    /**
     * Fetch location data from Google Geocoding API
     * 
     * @param float $latitude
     * @param float $longitude
     * @return array|false
     */
    protected function fetchFromGoogleAPI($latitude, $longitude)
    {
        if (empty($this->googleApiKey)) {
            log_message('error', 'Google API Key not configured');
            return false;
        }
        
        $url = sprintf(
            'https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s&key=%s&language=en',
            $latitude,
            $longitude,
            $this->googleApiKey
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            log_message('error', "Google API returned HTTP {$httpCode}");
            return false;
        }
        
        $data = json_decode($response, true);
        
        if (empty($data['status']) || $data['status'] !== 'OK') {
            log_message('error', 'Google API Error: ' . ($data['status'] ?? 'Unknown'));
            return false;
        }
        
        return $data;
    }
    
    /**
     * Structure location data from Google API response
     * 
     * @param array $apiData
     * @param float $latitude
     * @param float $longitude
     * @param string $locationHash
     * @return array
     */
    protected function structureLocationData($apiData, $latitude, $longitude, $locationHash)
    {
        $result = $apiData['results'][0] ?? [];
        $components = $result['address_components'] ?? [];
        
        $structured = [
            'location_hash' => $locationHash,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'formatted_address' => $result['formatted_address'] ?? '',
            'place_id' => $result['place_id'] ?? '',
            'plus_code' => $result['plus_code']['global_code'] ?? '',
            'area_name' => '',
            'street_address' => '',
            'landmark' => '',
            'locality' => '',
            'sublocality' => '',
            'municipality' => '',
            'district' => '',
            'region' => '',
            'country' => 'Ghana',
            'postal_code' => '',
            'gps_address' => '',
            'location_type' => $result['geometry']['location_type'] ?? 'APPROXIMATE',
            'viewport' => json_encode($result['geometry']['viewport'] ?? []),
            'address_components' => json_encode($components)
        ];
        
        // Parse address components
        foreach ($components as $component) {
            $types = $component['types'];
            $longName = $component['long_name'];
            $shortName = $component['short_name'];
            
            if (in_array('street_number', $types)) {
                $structured['street_address'] = $longName . ' ' . $structured['street_address'];
            }
            
            if (in_array('route', $types)) {
                $structured['street_address'] .= $longName;
            }
            
            if (in_array('sublocality', $types) || in_array('sublocality_level_1', $types)) {
                $structured['sublocality'] = $longName;
                $structured['area_name'] = $longName;
            }
            
            if (in_array('locality', $types)) {
                $structured['locality'] = $longName;
                if (empty($structured['area_name'])) {
                    $structured['area_name'] = $longName;
                }
            }
            
            if (in_array('administrative_area_level_2', $types)) {
                $structured['municipality'] = $longName;
                $structured['district'] = $longName;
            }
            
            if (in_array('administrative_area_level_1', $types)) {
                $structured['region'] = $longName;
            }
            
            if (in_array('country', $types)) {
                $structured['country'] = $longName;
            }
            
            if (in_array('postal_code', $types)) {
                $structured['postal_code'] = $longName;
            }
            
            if (in_array('point_of_interest', $types) || in_array('establishment', $types)) {
                $structured['landmark'] = $longName;
            }
        }
        
        // Clean up street address
        $structured['street_address'] = trim($structured['street_address']);
        
        // Generate Ghana GPS Address
        $structured['gps_address'] = $this->generateGhanaGPSAddress(
            $structured['region'],
            $latitude,
            $longitude
        );
        
        // Add metadata
        $structured['created_at'] = date('Y-m-d H:i:s');
        $structured['updated_at'] = date('Y-m-d H:i:s');
        
        return $structured;
    }
    
    /**
     * Generate Ghana Digital Address (Ghana Post GPS format)
     * 
     * @param string $region
     * @param float $latitude
     * @param float $longitude
     * @return string
     */
    protected function generateGhanaGPSAddress($region, $latitude, $longitude)
    {
        $regionCode = $this->ghanaRegionCodes[$region] ?? 'GH';
        
        // Generate area code from coordinates
        $areaCode = abs((int)(($latitude * 1000) % 1000));
        
        // Generate specific location code
        $locationCode = abs((int)(($longitude * 10000) % 10000));
        
        return sprintf('%s-%03d-%04d', $regionCode, $areaCode, $locationCode);
    }
    
    /**
     * Get location from IP address (fallback method)
     * 
     * @param string|null $ipAddress
     * @param string $type 'ip-api' or 'geoapi'
     * @return array|false
     */
    protected function getLocationFromIP($ipAddress = null, $type = 'ip-api')
    {
        try {
            if (empty($ipAddress)) {
                $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
            }
            
            // Don't try to geolocate local IPs
            if (empty($ipAddress) || $this->isLocalIP($ipAddress)) {
                // Return default Accra coordinates
                return [
                    'latitude' => 5.879265, 
                    'longitude' => -0.097947,
                    'source' => 'default'
                ];
            }
            
            // Use ip-api.com (free, no key required, but has rate limits)
            $url = [
                "ip-api" => "http://ip-api.com/json/{$ipAddress}?fields=status,lat,lon,country,countryCode",
                "geoapi" => "https://api.geoapify.com/v1/ipinfo?&apiKey=".getenv('GEOAPIFY')
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url[$type]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            
            $response = curl_exec($ch);
            curl_close($ch);
            
            if (empty($response)) {
                return false;
            }
            
            $data = json_decode($response, true);
            
            if($type == 'ip-api') {
                if ($data['status'] === 'success' && $data['countryCode'] === 'GH') {
                    return [
                        'latitude' => $data['lat'],
                        'longitude' => $data['lon'],
                        'source' => 'ip'
                    ];
                }
            } else if ($type == 'geoapi' && isset($data['city']) && isset($data['location']) && isset($data['country'])) {
                return [
                    'latitude' => $data['location']['latitude'],
                    'longitude' => $data['location']['longitude'],
                    'source' => 'ip'
                ];
            }
            
            return false;
            
        } catch (Exception $e) {
            log_message('error', 'IP Geolocation Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if IP is local/private
     * 
     * @param string $ip
     * @return bool
     */
    protected function isLocalIP($ip)
    {
        if (empty($ip)) {
            return true;
        }
        
        $privateRanges = [
            '::1' => '::1',
            '127.0.0.0' => '127.255.255.255',
            '10.0.0.0' => '10.255.255.255',
            '172.16.0.0' => '172.31.255.255',
            '192.168.0.0' => '192.168.255.255'
        ];
        
        $longIP = ip2long($ip);
        
        foreach ($privateRanges as $start => $end) {
            if ($longIP >= ip2long($start) && $longIP <= ip2long($end)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Save location to database
     * 
     * @param array $locationData
     * @return bool
     */
    protected function saveLocation($locationData)
    {
        try {
            // Check if location already exists
            $existing = $this->locationsModel->findByHash($locationData['location_hash']);
            
            if (!empty($existing)) {
                // Update existing record
                return $this->locationsModel->updateByHash(
                    $locationData['location_hash'],
                    $locationData
                );
            }
            
            // Insert new record
            return $this->locationsModel->insert($locationData);
            
        } catch (Exception $e) {
            log_message('error', 'Failed to save location: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get nearby locations within radius
     * 
     * @param float $latitude
     * @param float $longitude
     * @param float $radius in kilometers
     * @return array
     */
    public function getNearbyLocations($latitude, $longitude, $radius = 5)
    {
        return $this->locationsModel->findNearby($latitude, $longitude, $radius);
    }
    
    /**
     * Calculate distance between two points (Haversine formula)
     * 
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float Distance in kilometers
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earthRadius * $c;
    }
    
    /**
     * Validate if location is within Ghana boundaries
     * 
     * @param float $latitude
     * @param float $longitude
     * @return bool
     */
    public function isLocationInGhana($latitude, $longitude)
    {
        // Approximate Ghana boundaries
        $ghanaLat = ['min' => 4.5, 'max' => 11.5];
        $ghanaLng = ['min' => -3.5, 'max' => 1.5];
        
        return ($latitude >= $ghanaLat['min'] && $latitude <= $ghanaLat['max'] &&
                $longitude >= $ghanaLng['min'] && $longitude <= $ghanaLng['max']);
    }
    
    /**
     * Format success response
     * 
     * @param array $data
     * @param bool $fromCache
     * @return array
     */
    protected function successResponse($data, $fromCache = false)
    {
        return [
            'status' => 'success',
            'data' => $data,
            'cached' => $fromCache,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Format error response
     * 
     * @param string $message
     * @return array
     */
    protected function errorResponse($message)
    {
        return [
            'status' => 'error',
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Disable caching
     * 
     * @return void
     */
    public function disableCache()
    {
        $this->cacheEnabled = false;
    }
    
    /**
     * Enable caching
     * 
     * @return void
     */
    public function enableCache()
    {
        $this->cacheEnabled = true;
    }
}