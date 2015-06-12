<?php
namespace Nayjest\ViewComponents\Data\Processors\PhpArray;

use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Data\Operations\PaginateOperation;
use Nayjest\ViewComponents\Data\Processors\AbstractPaginateProcessor;

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