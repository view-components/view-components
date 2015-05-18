<?php
require __DIR__ . '/../../vendor/autoload.php';

use Nayjest\ViewComponents\Demo\Controller;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

Dotenv::load(__DIR__);
Dotenv::required([
    'DB_HOST',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD'
]);

$controller = new Controller;
$method = str_replace('/', '', $_SERVER['SCRIPT_NAME'])?:'index';
echo $controller->{$method}();
