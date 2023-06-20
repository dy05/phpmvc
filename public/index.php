<?php

ini_set('display_errors', 1);
session_start();

$generalRoute = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

$viewsDir = str_replace('/index.php', '', str_replace('public','Views/', str_replace('Public','Views/', $_SERVER['SCRIPT_FILENAME'])));
$viewsDir = str_replace('\index.php', '', $viewsDir);

$host_parts = explode(':', $host);

if ($host_parts[0] === 'localhost' && ! isset($host_parts[1])) {
    $addHost = explode('public', $_SERVER['REQUEST_URI']);
    $host .= $addHost[0] . 'public';
}

$generalRoute .= '://' . $host;
define('ROUTE', $generalRoute);
define('MEDIA', $generalRoute . '/img/');
define('VIEWS', $viewsDir);

// pour recuperer les fichiers des classes automatiquement
require '../App/Autoloader.php';

\RBAC\App\Autoloader::register();

$path = $_SERVER['REQUEST_URI'];
if (in_array($path, ['', '/', '/index', '/index.php'])) {
    $path = 'home';
}

if (substr($path,-1) === '/') {
    $path = substr($path, 0, -1);
}

if (substr($path,0, 1) === '/') {
    $path = substr($path, 1);
}

$router = new \RBAC\App\Router($path);

require_once '../routes.php';

$router->run();
