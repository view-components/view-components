<?php
namespace Nayjest\ViewComponents\Components;

use Nayjest\ViewComponents\BaseComponents\ComponentInterface;
use Nayjest\ViewComponents\BaseComponents\ComponentTrait;

class Dummy implements ComponentInterface
{
    use ComponentTrait;

    public function render()
    {
        return '';
    }
}
