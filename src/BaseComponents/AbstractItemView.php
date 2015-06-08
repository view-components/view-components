<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Data\DataAcceptorInterface;

abstract class AbstractItemView implements ComponentInterface, DataAcceptorInterface
{
    use ComponentTrait;

    /**
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    abstract public function render();

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
