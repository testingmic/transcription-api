<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Api;

$routes->setAutoRoute(true);

// Handle 404 errors and pass URL segments to BaseRoute::routing
$routes->set404Override("\App\Controllers\BaseRoute::control");

// request to api routing
$routes->get("/api", [Api::class, "index"]);

// request to api routing
$routes->match(["PUT", "DELETE", "GET", "POST", "OPTIONS"], "/api(:any)", [Api::class, "index/$1/$2/$3"]);
