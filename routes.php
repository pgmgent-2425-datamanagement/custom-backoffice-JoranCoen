<?php

//$router->get('/', function() { echo 'Dit is de index vanuit de route'; });
$router->setNamespace('\App\Controllers');
$router->get('/', 'HomeController@index');
$router->get('/transactions', 'transactionsController@transactions');
$router->get('/wallets', 'walletsController@wallets');
$router->get('/settings', 'settingsController@settings');