<?php

namespace Presentation\Framework\Control;

use Presentation\Framework\Input\InputOption;
use Presentation\Framework\Component\ControlView\PaginationView;
use Presentation\Framework\Data\DataProviderInterface;
use Presentation\Framework\Data\Operations\PaginateOperation;
use RuntimeException;

class PaginationControl implements ControlInterface
{
    use ControlTrait;

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

    protected function makeDefaultView()
    {
        return new PaginationView(
            (int)$this->pageInputOption->getValue(),
            (int)$this->getPageCount(),
            $this->pageInputOption->getKey()
        );
    }

}
