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
        header('Location: /login'); 
        exit();
    }
};

// Define routes
$router->setNamespace('\App\Controllers');

// API routes
$router->get('/api/coins', 'ApiController@apiGetAll');
$router->post('/api/coins', 'ApiController@apiCreate');

// Public routes
$router->get('/login', 'LoginController@login'); 
$router->post('/login', 'AuthController@login'); 

$router->before('GET', '/', $checkAuth);
$router->before('GET', '/transactions', $checkAuth);
$router->before('GET', '/wallets', $checkAuth);
$router->before('GET', '/user', $checkAuth);
$router->before('GET', '/profile', $checkAuth);
$router->before('GET', '/file-manager', $checkAuth);
$router->before('GET', '/settings', $checkAuth);

$router->post('/logout', 'AuthController@logout', $checkAuth);

$router->post('/profile/update', 'UserController@update', $checkAuth);

$router->post('/user/post', 'UserController@post', $checkAuth);
$router->post('/user/update', 'UserController@update', $checkAuth);
$router->post('/user/delete', 'UserController@delete', $checkAuth);

$router->post('/wallet/post', 'WalletController@post', $checkAuth);
$router->post('/wallet/update', 'WalletController@update', $checkAuth);
$router->post('/wallet/delete', 'WalletController@delete', $checkAuth);

$router->post('/transaction/post', 'TransactionController@post', $checkAuth);
$router->post('/transaction/update', 'TransactionController@update', $checkAuth);
$router->post('/transaction/delete', 'TransactionController@delete', $checkAuth);

$router->post('/file-manager/upload', 'FileManagerController@upload', $checkAuth);
$router->post('/file-manager/delete', 'FileManagerController@delete', $checkAuth);

$router->post('/search', 'SearchController@search', $checkAuth);

$router->get('/', 'DashboardController@dashboard');
$router->get('/user/(\d+)', 'DashboardController@userDetail');

$router->get('/transactions', 'TransactionsPageController@transactions');
$router->get('/transactions/(\d+)', 'TransactionsPageController@detail');

$router->get('/wallets', 'WalletsPageController@wallets');
$router->get('/wallets/(\d+)', 'WalletsPageController@detail');

$router->get('/profile', 'ProfileController@profile');

$router->get('/file-manager', 'FileManagerPageController@fileManager');

$router->get('/settings', 'SettingsPageController@settings');

$router->run();