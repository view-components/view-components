<?php
namespace Nayjest\ViewComponents\Demo\Components;

use Nayjest\ViewComponents\BaseComponents\ComponentInterface;
use Nayjest\ViewComponents\BaseComponents\ComponentTrait;

class PersonView extends Person implements ComponentInterface
{
    use ComponentTrait;

    public function render()
    {
        return "
            <div data-id=\"{$this->getId()}\"style='padding:10px; margin:10px; border:1px solid gray;'>
                <h3>{$this->getName()}</h3>
                <div><b>Id:</b>{$this->getId()}</div>
                <div><b>Role:</b>{$this->getRole()}</div>
                <div><b>Birthday:</b>{$this->getBirthday()} (<b>Age:</b> {$this->getAge()})</div>
            </div>";
    }
}

