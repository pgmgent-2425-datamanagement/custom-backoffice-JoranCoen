<?php

require_once __DIR__ . '/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require_once __DIR__ . '/config.php';

session_start();

try {
    $db = new PDO(
        $config['db_connection'] . ':dbname=' . $config['db_database'] . ';host=' . $config['db_host'] . ';port=' . $config['db_port'],
        $config['db_username'],
        $config['db_password']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

$router = new \Bramus\Router\Router();

$checkAuth = function () {
    if (!isset($_SESSION['user'])) {
        header('Location: login'); 
        exit();
    }
};

// Define routes
$router->setNamespace('\App\Controllers');

// Public routes
$router->get('/login', 'LoginController@login'); 
$router->post('/login', 'AuthController@login'); 

$router->before('GET', '/', $checkAuth);
$router->before('GET', '/transactions', $checkAuth);
$router->before('GET', '/wallets', $checkAuth);
$router->before('GET', '/profile', $checkAuth);
$router->before('GET', '/settings', $checkAuth);

$router->get('/logout', 'AuthController@logout'); 

$router->get('/', 'DashboardController@dashboard');
$router->get('/notifications', 'NotificationsController@notifications');
$router->get('/transactions', 'TransactionsController@transactions');
$router->get('/transactions/(\d+)', 'TransactionsController@detail');
$router->get('/wallets', 'WalletsController@wallets');
$router->get('/wallets/(\d+)', 'WalletsController@detail');
$router->get('/profile', 'ProfileController@profile');
$router->get('/settings', 'SettingsController@settings');

// Run the router
$router->run();