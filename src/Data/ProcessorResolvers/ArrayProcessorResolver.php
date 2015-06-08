<?php

namespace Nayjest\ViewComponents\Data\ProcessorResolvers;

class ArrayProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this->register(
            'Nayjest\ViewComponents\Data\Operations\Sorting',
            'Nayjest\ViewComponents\Data\Processors\PhpArray\SortingProcessor'
        );
        $this->register(
            'Nayjest\ViewComponents\Data\Operations\Filter',
            'Nayjest\ViewComponents\Data\Processors\PhpArray\FilterProcessor'
        );
    }
}
