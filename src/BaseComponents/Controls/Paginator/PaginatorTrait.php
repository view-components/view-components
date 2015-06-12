<?php

namespace Nayjest\ViewComponents\BaseComponents\Controls\Paginator;

use Nayjest\ViewComponents\BaseComponents\Controls\ControlTrait;
use Nayjest\ViewComponents\Data\Actions\PaginateAction;

/**
 * Class PaginatorTrait
 *
 * @property PaginateAction $action
 */
trait PaginatorTrait
{
    use ControlTrait {
        ControlTrait::getAction as private getActionInternal;
    }

    protected $pageSize;

    /** @var  PaginateHandler */
    protected $paginateHandler;

    public function __construct($pageSize = 50, $inputKey = 'page')
    {
        $this->paginateHandler = new PaginateHandler();
        $this->pageSize = $pageSize;
        $this->action = new PaginateAction($pageSize, $inputKey);
        $this->action->after($this->paginateHandler);
    }

    /**
     * @return PaginateAction
     */
    public function getAction()
    {
        return $this->getActionInternal();
    }

    public function getCurrentPage()
    {
        return $this->paginateHandler->getCurrentPage();
    }

    /**
     * Returns total items count excluding pagination.
     *
     * @return int
     */
    protected function getTotalCount()
    {
        return $this->paginateHandler->getTotalCount();
    }

    protected function getPageSize()
    {
        return $this->pageSize;
    }
}
