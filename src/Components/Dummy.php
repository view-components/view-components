<?php
namespace Presentation\Framework\Components;

use Presentation\Framework\BaseComponents\ComponentInterface;
use Presentation\Framework\BaseComponents\ComponentTrait;

class Dummy implements ComponentInterface
{
    use ComponentTrait;

    public function render()
    {
        return '';
    }
}
