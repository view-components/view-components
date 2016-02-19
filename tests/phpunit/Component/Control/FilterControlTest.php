<?php

namespace ViewComponents\ViewComponents\Test\Component\ManagedList\Control;

use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputOption;

class FilterControlTest extends PHPUnit_Framework_TestCase
{

    public function testDefaultView()
    {
        $filter = new FilterControl(
            'some_field',
            FilterOperation::OPERATOR_GTE,
            new InputOption('fld', [], 5)
        );
        self::assertTrue(!empty($filter->render()));
        $operation = $filter->getOperation();
        self::assertTrue($operation instanceof FilterOperation);
        self::assertTrue($operation->getField() === 'some_field');
        self::assertTrue($operation->getValue() === 5);
        self::assertTrue($operation->getOperator() === FilterOperation::OPERATOR_GTE);

    }
}