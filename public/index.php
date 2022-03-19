<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

ini_set('session.cookie_lifetime', '864000');

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);
$router->add('login', ['controller' => 'login', 'action' => 'show']);

$router->dispatch($_SERVER['QUERY_STRING']);
