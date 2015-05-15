<?php
namespace Nayjest\ViewComponents\Data\Processors\PhpArray;

use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Data\Operations\Sorting;
use Nayjest\ViewComponents\Data\Processors\ProcessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class SortingProcessor implements ProcessorInterface
{
    /**
     * @param $src
     * @param OperationInterface|Sorting $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $field = $operation->getField();
        $desc = $operation->getOrder() === Sorting::DESC;
        usort($src, function ($row1, $row2) use ($accessor, $field, $desc) {
            $val1 = $accessor->getValue($row1, $field);
            $val2 = $accessor->getValue($row2, $field);
            if ($val1 == $val2) {
                return 0;
            }
            $res = $val1 < $val2 ? -1 : 1;
            return $desc ? -$res : $res;

        });
        return $src;
    }
}
