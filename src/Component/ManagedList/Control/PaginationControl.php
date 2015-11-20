<?php

namespace Presentation\Framework\Component\ManagedList\Control;

use Presentation\Framework\Base\CompoundPartInterface;
use Presentation\Framework\Base\CompoundPartTrait;
use Presentation\Framework\Base\ViewAggregate;
use Presentation\Framework\Component\CompoundComponent;
use Presentation\Framework\Input\InputOption;
use Presentation\Framework\Component\ManagedList\Control\View\PaginationView;
use Presentation\Framework\Data\DataProviderInterface;
use Presentation\Framework\Data\Operation\PaginateOperation;
use RuntimeException;

class PaginationControl extends ViewAggregate implements ControlInterface, CompoundPartInterface
{
    use CompoundPartTrait;

    /**
     * @var \Presentation\Framework\Input\InputOption
     */
    private $pageInputOption;
    /**
     * @var int
     */
    protected $recordsPerPage;

    protected $operation;

    protected $dataProvider;

    /**
     * @param \Presentation\Framework\Input\InputOption $page
     * @param $recordsPerPage
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(
        InputOption $page,
        $recordsPerPage,
        DataProviderInterface $dataProvider
    )
    {
        $this->pageInputOption = $page;
        $this->recordsPerPage = $recordsPerPage;
        $this->dataProvider = $dataProvider;
        parent::__construct(new PaginationView(
            (int)$this->pageInputOption->getValue(),
            function() {
                return (int)$this->getPageCount();
            },
            $this->pageInputOption->getKey()
        ));
    }

    public function isManualFormSubmitRequired()
    {
        return false;
    }

    public function getComponentName()
    {
        return $this->componentName ?: 'pagination_' . rand();
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
            $this->operation = new PaginateOperation($page, $this->recordsPerPage);
        }
        return $this->operation;
    }

    protected function getTotalRecordsCount()
    {
        $operations = $this->dataProvider->operations();

        if ($this->operation === null || !$operations->contains($this->operation)) {
            throw new RuntimeException(
                'Trying to get total count for pagination
                from data provider having not configured operations.'
            );
        }
        $operations->remove($this->operation);
        $count = $this->dataProvider->count();
        $operations->add($this->operation);
        return $count;
    }

    protected function getPageCount()
    {
        return ceil($this->getTotalRecordsCount() / $this->recordsPerPage);
    }
}
