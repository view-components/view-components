<?php

namespace Nayjest\ViewComponents\Data\Actions;

use Nayjest\ViewComponents\Common\InputValueReader;
use Nayjest\ViewComponents\Data\Actions\Base\AbstractSimpleAction;
use Nayjest\ViewComponents\Data\Operations\Filter as FilterOperation;

/**
 * Class FilterAction
 *
 * @property FilterOperation $operation
 */
class FilterAction extends AbstractSimpleAction
{

    protected function initializeOperation($value)
    {
        $this->operation->setValue($value);
    }

    /**
     * @param string|null $dataField
     * @param string $operator
     * @param InputValueReader $inputReader
     */
    public function __construct(
        $dataField = null,
        $operator = FilterOperation::OPERATOR_EQ,
        InputValueReader $inputReader = null
    )
    {
        // Use same input key like $dataField if empty
        if ($inputReader === null && $dataField !== null)
        {
            $inputReader = new InputValueReader($dataField);
        // Use same $dataField like input key if empty
        } elseif ($dataField === null)
        {
            $dataField = $inputReader->getInputKey();
        }

        parent::__construct(
            $inputReader,
            new FilterOperation($dataField, $operator)
        );
    }
}
