<?php

namespace ViewComponents\ViewComponents\Component\Control;

use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Component\Control\View\PaginationControlView;
use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Data\DataAggregateInterface;
use ViewComponents\ViewComponents\Data\DataProviderInterface;
use ViewComponents\ViewComponents\Data\Operation\SortOperation;
use ViewComponents\ViewComponents\Input\InputOption;
use ViewComponents\ViewComponents\Data\Operation\PaginateOperation;
use RuntimeException;

/**
 * Class PaginationControl
 */
class PaginationControl extends Part implements ControlInterface
{
    /**
     * @var InputOption
     */
    protected $pageInputOption;

    /**
     * @var int
     */
    protected $pageSize;

    protected $operation;

    /** @var  DataProviderInterface|null */
    private $dataProvider;

    /**
     * @param InputOption $page
     * @param int $pageSize
     * @param DataProviderInterface|null $dataProvider can be injected automatically when attaching to compound
     */
    public function __construct(
        InputOption $page,
        $pageSize,
        DataProviderInterface $dataProvider = null
    )
    {
        $this->pageInputOption = $page;
        $this->pageSize = $pageSize;
        parent::__construct($this->makeDefaultView(), 'pagination', 'container');
        $this->dataProvider = $dataProvider;
    }

    /**
     * This method is used by root component (e.g. ManagedList)
     * to determine that submit button should be present.
     *
     * @see \ViewComponents\ViewComponents\Component\ManagedList::hideSubmitButtonIfNotUsed
     *
     * @return bool
     */
    public function isManualFormSubmitRequired()
    {
        return false;
    }

    /**
     * @return PaginateOperation
     */
    public function getOperation()
    {
        if ($this->operation === null) {
            $page = $this->pageInputOption->getValue();
            $this->operation = new PaginateOperation($page, $this->pageSize);
        }
        return $this->operation;
    }

    /**
     * @return InputOption
     */
    public function getPageInputOption()
    {
        return $this->pageInputOption;
    }

    /**
     * @param null|DataProviderInterface $dataProvider
     * @return $this
     */
    public function setDataProvider(DataProviderInterface $dataProvider = null)
    {
        $this->dataProvider = $dataProvider;
        return $this;
    }

    /**
     * @return int
     */
    protected function getTotalRecordsCount()
    {
        /** remove sorting because it will produce invalid SQL that fails on Postgres
         * @see https://github.com/view-components/view-components/issues/33
         */
        $operations = $this->getDataProvider()->operations();
        $removed = [];
        foreach ($operations as $operation) {
            if ($operation instanceof SortOperation || $operation instanceof PaginateOperation) {
                $removed[] = $operation;
                $operations->remove($operation);
            }
        }
        $count = $this->getDataProvider()->count();
        $operations->addMany($removed);
        return $count;
    }

    /**
     * @return int
     */
    protected function getPageCount()
    {
        return (int)ceil($this->getTotalRecordsCount() / $this->pageSize);
    }

    /**
     * @return null|DataProviderInterface
     */
    protected function getDataProvider()
    {
        if ($this->dataProvider === null && $this->root && method_exists($this->root, 'getDataProvider')) {
            $this->dataProvider = $this->root->getDataProvider();
        }
        return $this->dataProvider;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Sets page size.
     *
     * @param int $pageSize
     * @return PaginationControl
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    /**
     * Returns current page number.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return (int)$this->pageInputOption->getValue();
    }

    protected function makeDefaultView()
    {
        return new PaginationControlView();
    }

    protected function setViewData()
    {
        $view = $this->getView();
        if (!$view instanceof DataAggregateInterface) {
            return;
        }
        $view->mergeData([
            'total' => $this->getPageCount(),
            'current' => $this->getCurrentPage(),
        ]);
    }

    /**
     * Renders components.
     *
     * @return string
     */
    public function render()
    {
        $this->setViewData();
        return parent::render();
    }
}
