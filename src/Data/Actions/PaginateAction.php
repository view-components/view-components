<?php

namespace Nayjest\ViewComponents\Data\Actions;

use Nayjest\ViewComponents\Common\InputValueReader;
use Nayjest\ViewComponents\Data\Actions\Base\AbstractSimpleAction;
use Nayjest\ViewComponents\Data\Operations\PaginateOperation;

/**
 * Class PaginateAction
 *
 * @property PaginateOperation $operation
 */
class PaginateAction extends AbstractSimpleAction
{

    protected function initializeOperation($value)
    {
        $this->operation->setPageNumber($value);
    }

    public function __construct(
        $pageSize = 50,
        $inputKey = 'page'
    )
    {
        parent::__construct(
            new InputValueReader($inputKey, 1),
            new PaginateOperation(1, $pageSize)
        );
    }
}
