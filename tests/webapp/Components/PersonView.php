<?php
namespace ViewComponents\ViewComponents\WebApp\Components;

use Nayjest\Tree\ChildNodeTrait;
use Nayjest\Tree\NodeTrait;
use ViewComponents\ViewComponents\Base\ComponentInterface;

use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Data\DataAcceptorInterface;
use ViewComponents\ViewComponents\Rendering\ViewTrait;

class PersonView extends Person implements ViewComponentInterface, DataAcceptorInterface
{
    use ViewTrait;
    use ChildNodeTrait;

    public function setData($data)
    {
        foreach($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
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

