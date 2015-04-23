<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Rendering\ChildViewTrait;
use Nayjest\ViewComponents\Rendering\ViewTrait;
use Nayjest\ViewComponents\Structure\ChildNodeTrait;

trait ComponentTrait
{
    use ChildNodeTrait;
    use ViewTrait;
    use ChildViewTrait;
}
