<?php

namespace Nayjest\ViewComponents\Data\ProcessorResolvers;

class ArrayProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this->register(
            'Nayjest\ViewComponents\Data\Operations\SortOperation',
            'Nayjest\ViewComponents\Data\Processors\PhpArray\SortProcessor'
        );
        $this->register(
            'Nayjest\ViewComponents\Data\Operations\FilterOperation',
            'Nayjest\ViewComponents\Data\Processors\PhpArray\FilterProcessor'
        );
    }
}
