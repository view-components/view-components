<?php
namespace Presentation\Framework\Data\Operation;


class PaginateOperation implements OperationInterface
{
    protected $pageNumber;

    protected $pageSize;

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
     * @param $pageNumber
     * @return $this
     */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param $pageSize
     * @return $this
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        return $this;
    }
}