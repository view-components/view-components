<?php

namespace Presentation\Framework\Component\ManagedList\Control;

use Presentation\Framework\Base\CompoundPartInterface;
use Presentation\Framework\Base\CompoundPartTrait;
use Presentation\Framework\Base\ViewAggregate;
use Presentation\Framework\Component\CompoundComponent;
use Presentation\Framework\Component\ManagedList\ManagedList;
use Presentation\Framework\Initialization\InitializableInterface;
use Presentation\Framework\Initialization\InitializableTrait;
use Presentation\Framework\Input\InputOption;
use Presentation\Framework\Component\ManagedList\Control\View\PaginationView;
use Presentation\Framework\Data\Operation\PaginateOperation;
use RuntimeException;

class PaginationControl extends ViewAggregate implements ControlInterface, CompoundPartInterface, InitializableInterface
{
    use CompoundPartTrait;
    use InitializableTrait;

    /**
     * @var InputOption
     */
    protected $pageInputOption;

    /**
     * @var int
     */
    protected $pageSize;

    protected $operation;

    /**
     * @param InputOption $page
     * @param int $pageSize
     */
    public function __construct(
        InputOption $page,
        $pageSize
    )
    {
        $this->pageInputOption = $page;
        $this->pageSize = $pageSize;
        parent::__construct();
    }

    public function isManualFormSubmitRequired()
    {
        return false;
    }

    /**
     * @param CompoundComponent $root
     * @return string|null
     */
    public function resolveParentName(CompoundComponent $root)
    {
        return 'container';
    }

    public function getOperation()
    {
        if ($this->operation === null) {
            $page = $this->pageInputOption->getValue();
            $this->operation = new PaginateOperation($page, $this->pageSize);
        }
        return $this->operation;
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

    protected function getDataProvider()
    {
        /** @var ManagedList $ml */
        $ml =  $this->requireInitializer();
        return $ml->getDataProvider();
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

    protected function makeDefaultView()
    {
        return new PaginationView(
            (int)$this->pageInputOption->getValue(),
            function() {
                return (int)$this->getPageCount();
            },
            $this->pageInputOption->getKey()
        );
    }
}
