<?php
// Here you can initialize variables that will be available to your tests
use Codeception\Util\Fixtures;

Fixtures::add(
    'users_array',
    include(dirname(dirname(__DIR__)).'/fixtures/users.php')
);