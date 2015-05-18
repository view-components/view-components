<?php
namespace Nayjest\ViewComponents\Data;

use Nayjest\ViewComponents\Data\Operations\OperationInterface;
use Nayjest\ViewComponents\Data\Processors\ProcessorInterface;

class DbTableProcessorResolver implements ProcessorResolverInterface
{
    protected static $processors;

    protected static function getProcessors()
    {
        if (self::$processors === null) {
            $namespace = 'Nayjest\\ViewComponents\\Data';
            $operations = $namespace . '\\Operations';
            $processors = $namespace . '\\Processors\\DbTable';
            self::$processors = [
                "$operations\\Sorting" => "$processors\\SortingProcessor",
                "$operations\\Filter" => "$processors\\FilterProcessor",
            ];
        }
        return self::$processors;
    }

    /**
     * @param OperationInterface $operation
     * @return ProcessorInterface
     */
    public function getProcessor(OperationInterface $operation)
    {
        $class = get_class($operation);
        $processorClass = self::getProcessors()[$class];
        return new $processorClass();
    }
}
