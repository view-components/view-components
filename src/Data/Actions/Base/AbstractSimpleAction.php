<?php

namespace Nayjest\ViewComponents\Data\Actions\Base;

use Nayjest\ViewComponents\Common\InputValueReader;
use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\Data\Operations\OperationInterface;

/**
 * Class AbstractSimpleAction
 *
 * Action based on single input value
 * that provides single operation.
 *
 */
abstract class AbstractSimpleAction extends AbstractAction
{
    protected $operation;

    /** @var  InputValueReader */
    protected $inputValueReader;

    abstract protected function initializeOperation($value);

    public function __construct(
        InputValueReader $inputValueReader,
        OperationInterface $operation
    )
    {
        $this->inputValueReader = $inputValueReader;
        $this->operation = $operation;
    }

    protected function applyInternal(DataProviderInterface $provider, array $input)
    {
        if ($this->inputValueReader->hasValue()) {
            $this->initializeOperation(
                $this->inputValueReader->getValue()
            );
            $provider->operations()->add($this->operation);
        }
    }

    public function apply(DataProviderInterface $provider, array $input)
    {
        $this->inputValueReader->initialize($input);
        parent::apply($provider, $input);
    }

    public function getInputValueReader()
    {
        return $this->inputValueReader;
    }
}
