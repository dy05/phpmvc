<?php

ini_set('display_errors', 1);
session_start();

$generalRoute = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

$viewsDir = str_replace('/absences.php', '', str_replace('public','Views/', str_replace('Public','Views/', $_SERVER['SCRIPT_FILENAME'])));
$viewsDir = str_replace('\index.php', '', $viewsDir);

if ($host === 'localhost') {
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

