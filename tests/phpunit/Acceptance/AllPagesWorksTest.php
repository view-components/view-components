<?php
namespace ViewComponents\ViewComponents\Test\Acceptance;

use ViewComponents\ViewComponents\WebApp\Controller;
use ViewComponents\TestingHelpers\Application\Http\EasyRouting;
use ViewComponents\TestingHelpers\Test\Acceptance\AbstractAcceptanceTest;

class AllPagesWorksTest extends AbstractAcceptanceTest
{
    public function testAllPages()
    {
        $this->assertPagesWorks(EasyRouting::getUris(Controller::class));
    }
}
