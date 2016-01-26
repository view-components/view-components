<?php

namespace Presentation\Framework\Test\Component\ManagedList\Control\View;

use PHPUnit_Framework_TestCase;
use Presentation\Framework\Component\ManagedList\Control\View\PaginationView;

class PaginationViewTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $_SERVER['HTTP_HOST'] = 'http://localhost';
        $view = new PaginationView(1, 10, 'page');
        echo $view->render();
    }
}