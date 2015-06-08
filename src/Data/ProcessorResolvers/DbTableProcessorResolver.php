<?php

namespace Nayjest\ViewComponents\Data\ProcessorResolvers;

class DbTableProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this->register(
            'Nayjest\ViewComponents\Data\Operations\Sorting',
            'Nayjest\ViewComponents\Data\Processors\DbTable\SortingProcessor'
        );
        $this->register(
            'Nayjest\ViewComponents\Data\Operations\Filter',
            'Nayjest\ViewComponents\Data\Processors\DbTable\FilterProcessor'
        );
    }
}
