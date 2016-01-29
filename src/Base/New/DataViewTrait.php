<?php
namespace Presentation\Framework\Base;


/**
 * Implementation of DataAcceptorInterface
 * @see DataAcceptorInterface
 *
 */
trait DataViewTrait
{

    use AdvancedViewTrait;

    private $data;

    /**
     * @return string
     */
    abstract public function renderData();

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function renderInternal()
    {
        return $this->renderData();
    }
}
