<?php
namespace ViewComponents\ViewComponents\WebApp\Components;

use Nayjest\Tree\ChildNodeTrait;

use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Data\DataAggregateInterface;
use ViewComponents\ViewComponents\Data\DataAggregateTrait;
use ViewComponents\ViewComponents\Rendering\ViewTrait;

class PersonView extends Person implements ViewComponentInterface, DataAggregateInterface
{
    use ViewTrait;
    use ChildNodeTrait;
    use DataAggregateTrait {
        DataAggregateTrait::setData as setDataInternal;
        DataAggregateTrait::getData as getDataInternal;
    }

    public function setData($data)
    {
        \mp\setValues($this, is_object($data) ? get_object_vars($data) : $data);
        return $this;
    }

    public function getData()
    {
        return get_object_vars($this);
    }

    public function render()
    {
        return "
            <div data-id=\"{$this->getId()}\" style='padding:10px; margin:10px; border:1px solid gray;'>
                <h3>{$this->getName()}</h3>
                <div><b>Id:</b>{$this->getId()}</div>
                <div><b>Role:</b>{$this->getRole()}</div>
                <div><b>Birthday:</b>{$this->getBirthday()} (<b>Age:</b> {$this->getAge()})</div>
            </div>";
    }
}

