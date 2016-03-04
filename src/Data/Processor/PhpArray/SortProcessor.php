<?php
namespace ViewComponents\ViewComponents\Data\Processor\PhpArray;

use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\Operation\SortOperation;
use ViewComponents\ViewComponents\Data\Processor\ProcessorInterface;
use mp;

class SortProcessor implements ProcessorInterface
{
    /**
     * Applies operation to source and returns modified source.
     *
     * @param $src
     * @param OperationInterface|SortOperation $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {

        $field = $operation->getField();
        $desc = $operation->getOrder() === SortOperation::DESC;
        usort($src, function ($row1, $row2) use ($field, $desc) {
            $val1 = mp\getValue($row1, $field);
            $val2 = mp\getValue($row2, $field);
            if ($val1 == $val2) {
                return 0;
            }
            $res = $val1 < $val2 ? -1 : 1;
            return $desc ? -$res : $res;
        });
        return $src;
    }
}
