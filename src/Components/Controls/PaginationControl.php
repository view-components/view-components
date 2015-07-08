<?php

namespace Presentation\Framework\Components\Controls;

use Presentation\Framework\BaseComponents\ContainerInterface;
use Presentation\Framework\BaseComponents\Controls\ControlInterface;
use Presentation\Framework\BaseComponents\ViewComponentAggregateTrait;
use Presentation\Framework\Common\InputOption;
use Presentation\Framework\Components\Controls\View\PaginationView;
use Presentation\Framework\Components\Dummy;
use Presentation\Framework\Data\DataProviderInterface;
use Presentation\Framework\Data\Operations\PaginateOperation;
use RuntimeException;

class PaginationControl implements ControlInterface, ContainerInterface
{
    use ViewComponentAggregateTrait;

    /**
     * @var InputOption
     */
    private $page;
    /**
     * @var int
     */
    private $recordsPerPage;

    protected $operation;

    protected $dataProvider;


    /**
     * @param InputOption $page
     * @param $recordsPerPage
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(
        InputOption $page,
        $recordsPerPage,
        DataProviderInterface $dataProvider
    )
    {
        $this->page = $page;
        $this->recordsPerPage = $recordsPerPage;
        $this->dataProvider = $dataProvider;
    }

    public function getOperation()
    {
        if ($this->operation === null) {
            $page = $this->page->getValue();
            $this->operation = new PaginateOperation($page, $this->recordsPerPage);
        }
        return $this->operation;
    }

    protected function getTotalRecordsCount()
    {
        $operations = $this->dataProvider->operations();

        if ($this->operation === null || !$operations->has($this->operation)) {
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
        $pageCount = $this->getPageCount();
        if ($pageCount <= 1) {
            return new Dummy();
        }
        return new PaginationView(
            (int)$this->page->getValue(),
            $pageCount,
            $this->page->getKey()
        );
    }

}
