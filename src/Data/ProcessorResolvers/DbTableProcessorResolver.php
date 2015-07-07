<?php

namespace Presentation\Framework\Data\ProcessorResolvers;

class DbTableProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this->register(
            'Presentation\Framework\Data\Operations\SortOperation',
            'Presentation\Framework\Data\Processors\DbTable\SortProcessor'
        );
        $this->register(
            'Presentation\Framework\Data\Operations\FilterOperation',
            'Presentation\Framework\Data\Processors\DbTable\FilterProcessor'
        );
    }
}
