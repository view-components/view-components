<?php

namespace ViewComponents\ViewComponents\Data\Processor;

use ViewComponents\ViewComponents\Data\Operation\CustomOperation;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;

class CustomProcessor
{
    /**
     * Applies operation to data source and returns modified data source.
     *
     * @param $src
     * @param OperationInterface|CustomOperation $operation
     * @return mixed modified data source
     */
    public function process($src, OperationInterface $operation)
    {
        $callable = $operation->getCallback();
        $arguments = array_merge([$src], $operation->getArguments());
        $res = call_user_func_array($callable, $arguments);
        return $res ?: $src;
    }
}
