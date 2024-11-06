<?php

use Bramus\Router\Router;

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
$router->before('GET', '/user', $checkAuth);
$router->before('GET', '/profile', $checkAuth);
$router->before('GET', '/files', $checkAuth);
$router->before('GET', '/settings', $checkAuth);

$router->post('/logout', 'AuthController@logout', $checkAuth);
$router->post('/profile', 'UserController@update', $checkAuth);
$router->post('/user/(\d+)', 'UserController@update', $checkAuth);
$router->post('/wallet/(\d+)', 'WalletController@update', $checkAuth);
$router->post('/transaction/(\d+)', 'TransactionController@update', $checkAuth);
$router->post('/file-manager/upload', 'FileManagerController@upload', $checkAuth);
$router->post('/file-manager/delete', 'FileManagerController@delete', $checkAuth);

$router->get('/', 'DashboardController@dashboard');
$router->get('/user/(\d+)', 'DashboardController@userDetail');
$router->get('/notifications', 'NotificationsController@notifications');
$router->get('/transactions', 'TransactionsPageController@transactions');
$router->get('/transactions/(\d+)', 'TransactionsPageController@detail');
$router->get('/wallets', 'WalletsPageController@wallets');
$router->get('/wallets/(\d+)', 'WalletsPageController@detail');
$router->get('/profile', 'ProfileController@profile');
$router->get('/file-manager', 'FileManagerPageController@fileManager');
$router->get('/settings', 'SettingsPageController@settings');

$router->run();