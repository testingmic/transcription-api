<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Api;
use App\Controllers\HomeController;

$routes->setAutoRoute(true);

$routes->get("/", [HomeController::class, "index"]);
$routes->get("/privacy", [HomeController::class, "privacy"]);
$routes->get("/terms", [HomeController::class, "terms"]);
$routes->get("/data-deletion", [HomeController::class, "dataDeletion"]);
$routes->get("/pricing", [HomeController::class, "pricing"]);
$routes->get("/contact", [HomeController::class, "contact"]);
$routes->post("/contact", [HomeController::class, "contactSubmit"]);

// Handle 404 errors and pass URL segments to BaseRoute::routing
$routes->set404Override("\App\Controllers\BaseRoute::control");

// request to api routing
$routes->get("/api", [Api::class, "index"]);

// request to api routing
$routes->match(["PUT", "DELETE", "GET", "POST", "OPTIONS"], "/api(:any)", [Api::class, "index/$1/$2/$3"]);
