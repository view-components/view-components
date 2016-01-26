<?php

namespace Presentation\Framework\Test\Component\ManagedList\Control;

use PHPUnit_Framework_TestCase;
use Presentation\Framework\Component\ManagedList\Control\FilterControl;
use Presentation\Framework\Data\Operation\FilterOperation;
use Presentation\Framework\Input\InputOption;

class FilterControlTest extends PHPUnit_Framework_TestCase
{

    public function testDefaultView()
    {
        $filter = new FilterControl(
            'some_field',
            FilterOperation::OPERATOR_EQ,
            new InputOption('fld', [], 5)
        );
        $filter->useDefaultView();
        self::assertTrue($filter->children()->count() > 0);
    }
}