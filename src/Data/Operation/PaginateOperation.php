<?php
namespace ViewComponents\ViewComponents\Data\Operation;

/**
 * DataProvider pagination operation.
 */
class PaginateOperation implements OperationInterface
{
    protected $pageNumber;

    protected $pageSize;

    /**
     * Constructor.
     *
     * @param int $pageNumber
     * @param int $pageSize
     */
    public function __construct($pageNumber = 1, $pageSize = 50)
    {
        $this->pageNumber = $pageNumber;
        $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * @param int $pageNumber
     * @return $this
     */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
        return $this;
    }

    /**
     * Returns page size.
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Sets page size.
     *
     * @param $pageSize
     * @return $this
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        return $this;
    }
}
