<?php

namespace Nayjest\ViewComponents\BaseComponents\Controls\Paginator;

use Nayjest\ViewComponents\Data\Actions\Base\ActionInterface;
use Nayjest\ViewComponents\Data\Actions\Base\RequiredHandler;
use Nayjest\ViewComponents\Data\Actions\PaginateAction;
use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\Data\Operations\PaginateOperation;

class PaginateHandler extends RequiredHandler
{
    protected $totalCount;
    protected $currentPage;

    /** @var  PaginateOperation */
    protected $paginateOperation;

    /** @var DataProviderInterface */
    protected $dataProvider;

    /**
     * @param ActionInterface|PaginateAction $action
     * @param DataProviderInterface $dataProvider
     * @param array $input
     * @return bool
     */
    public function __invoke(
        ActionInterface $action,
        DataProviderInterface $dataProvider,
        array $input
    )
    {
        $this->paginateOperation = $action->getOperation();
        $this->dataProvider = $dataProvider;
        return parent::__invoke($action, $dataProvider, $input);
    }

    public function getTotalCount()
    {
        $this->checkIsExecuted();
        $this->dataProvider->operations()->remove($this->paginateOperation);
        $count = $this->dataProvider->count();
        $this->dataProvider->operations()->add($this->paginateOperation);
        return $count;
    }

    public function getCurrentPage()
    {
        $this->checkIsExecuted();
        return $this->paginateOperation->getPageNumber();
    }

    /**
     * Currently required only for laravel pagination
     *
     * @return DataProviderInterface
     */
    public function getDataProvider()
    {
        $this->checkIsExecuted();
        return $this->dataProvider;
    }

}