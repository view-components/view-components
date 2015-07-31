<?php
namespace Presentation\Framework\Demo\Components;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Rendering\ViewTrait;

class PersonView extends Person implements ComponentInterface
{
    use ViewTrait;
    use NodeTrait;
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

