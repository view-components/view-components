<?php

use Nayjest\ViewComponents\Demo\Controller;

require __DIR__ . '/../../vendor/autoload.php';
//require __DIR__. '/Controller.php';
$controller = new Controller;
$method = str_replace('/', '', $_SERVER['REQUEST_URI'])?:'index';
echo $controller->{$method}();
