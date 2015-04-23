<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Rendering\ChildViewTrait;
use Nayjest\ViewComponents\Rendering\ViewTrait;
use Nayjest\ViewComponents\Structure\ChildTrait;

trait ComponentTrait
{
    use ChildTrait;
    use ViewTrait;
    use ChildViewTrait;
}
