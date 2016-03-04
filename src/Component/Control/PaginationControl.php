<?php

namespace ViewComponents\ViewComponents\Component\Control;

use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Component\Control\View\PaginationControlView;
use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Data\DataAcceptorInterface;
use ViewComponents\ViewComponents\Data\DataProviderInterface;
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
    ) {
        $this->pageInputOption = $page;
        $this->pageSize = $pageSize;
        parent::__construct($this->makeDefaultView(), 'pagination', 'container');
        $this->dataProvider = $dataProvider;
    }

    public function isManualFormSubmitRequired()
    {
        return false;
    }

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

    protected function getTotalRecordsCount()
    {
        $operations = $this->getDataProvider()->operations();

        if ($this->operation === null || !$operations->contains($this->operation)) {
            throw new RuntimeException(
                'Trying to get total count for pagination
                from data provider having not configured operations.'
            );
        }
        $operations->remove($this->operation);
        $count = $this->getDataProvider()->count();
        $operations->add($this->operation);
        return $count;
    }

    protected function getPageCount()
    {
        return ceil($this->getTotalRecordsCount() / $this->pageSize);
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
     * @param int $pageSize
     * @return PaginationControl
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        return $this;
    }

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
        if (!$view instanceof DataAcceptorInterface) {
            return;
        }
        $view->setData([
            'total' => $this->getPageCount(),
            'current' => $this->getCurrentPage(),
        ]);
    }

    public function render()
    {
        $this->setViewData();
        return parent::render();
    }
}
