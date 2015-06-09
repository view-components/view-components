<?php
namespace Nayjest\ViewComponents\Components\Html;

use Nayjest\ViewComponents\BaseComponents\Html\AbstractTag;

class Div extends AbstractTag
{
    public function getTagName()
    {
        return 'span';
    }
}
