<?php

namespace Presentation\Framework\Data\ProcessorResolvers;

class ArrayProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this->register(
            'Presentation\Framework\Data\Operations\SortOperation',
            'Presentation\Framework\Data\Processors\PhpArray\SortProcessor'
        );
        $this->register(
            'Presentation\Framework\Data\Operations\FilterOperation',
            'Presentation\Framework\Data\Processors\PhpArray\FilterProcessor'
        );
        $this->register(
            'Presentation\Framework\Data\Operations\PaginateOperation',
            'Presentation\Framework\Data\Processors\PhpArray\PaginateProcessor'
        );
    }
}
