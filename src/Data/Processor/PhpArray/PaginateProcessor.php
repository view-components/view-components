<?php
namespace ViewComponents\ViewComponents\Data\Processor\PhpArray;

use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\Operation\PaginateOperation;
use ViewComponents\ViewComponents\Data\Processor\AbstractPaginateProcessor;

class PaginateProcessor extends AbstractPaginateProcessor
{
    /**
     * @param array $src
     * @param OperationInterface|PaginateOperation $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {
        return array_slice(
            $src,
            $this->getOffset($operation),
            $operation->getPageSize()
        );
    }
}