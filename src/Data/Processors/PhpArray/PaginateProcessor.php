<?php
namespace Presentation\Framework\Data\Processors\PhpArray;

use Presentation\Framework\Data\Operations\OperationInterface;
use Presentation\Framework\Data\Operations\PaginateOperation;
use Presentation\Framework\Data\Processors\AbstractPaginateProcessor;

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