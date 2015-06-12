<?php

namespace Nayjest\ViewComponents\Data\ProcessorResolvers;

class DbTableProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this->register(
            'Nayjest\ViewComponents\Data\Operations\SortOperation',
            'Nayjest\ViewComponents\Data\Processors\DbTable\SortProcessor'
        );
        $this->register(
            'Nayjest\ViewComponents\Data\Operations\FilterOperation',
            'Nayjest\ViewComponents\Data\Processors\DbTable\FilterProcessor'
        );
    }
}
