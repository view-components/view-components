<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Data\DataAcceptorInterface;

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
