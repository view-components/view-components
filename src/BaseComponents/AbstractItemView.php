<?php
namespace Presentation\Framework\BaseComponents;

use Presentation\Framework\Data\DataAcceptorInterface;

abstract class AbstractItemView implements ComponentInterface, DataAcceptorInterface
{
    use ComponentTrait;

    protected $data;

    abstract public function render();

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
}
