<?php
namespace Presentation\Framework\Base;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Data\DataAcceptorInterface;
use Presentation\Framework\Rendering\ViewTrait;

/**
 * Class AbstractDataView
 *
 * Abstract class for view-model components
 *
 */
abstract class AbstractDataView implements ComponentInterface, DataAcceptorInterface
{
    use ViewTrait;
    use NodeTrait;
    use ComponentTrait {
        ComponentTrait::render as RenderInternal;
    }

    protected $data;

    /**
     * @return string
     */
    abstract public function renderData();

    /**
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

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

    public function render()
    {
        return $this->renderData() . $this->renderChildren();
    }
}
