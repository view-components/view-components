<?php
require __DIR__ . '/../../vendor/autoload.php';

use Nayjest\ViewComponents\Demo\Controller;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$controller = new Controller;
$method = str_replace('/', '', $_SERVER['REQUEST_URI'])?:'index';
echo $controller->{$method}();
