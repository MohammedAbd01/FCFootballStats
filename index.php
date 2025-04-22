<?php
require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'core/Router.php';

// Initialize router
$router = new Router();

// Define routes
$router->add('', 'HomeController', 'index');
$router->add('login', 'AuthController', 'login');
$router->add('signup', 'AuthController', 'signup');
$router->add('logout', 'AuthController', 'logout');
$router->add('dashboard', 'DashboardController', 'index');
$router->add('admin/dashboard', 'AdminController', 'index');
$router->add('admin/players', 'AdminController', 'players');
$router->add('admin/matches', 'AdminController', 'matches');
$router->add('player/{id}', 'PlayerController', 'profile');
$router->add('match/{id}', 'MatchController', 'view');

// Handle the request
try {
    $router->dispatch();
} catch (Exception $e) {
    // Handle errors
    if ($e->getCode() === 404) {
        header("HTTP/1.0 404 Not Found");
        require_once 'views/errors/404.php';
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        require_once 'views/errors/500.php';
    }
} 