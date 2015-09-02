<?php
namespace Presentation\Framework\Data\Processor\PhpArray;

use Presentation\Framework\Data\Operation\OperationInterface;
use Presentation\Framework\Data\Operation\PaginateOperation;
use Presentation\Framework\Data\Processor\AbstractPaginateProcessor;

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