<?php
namespace Nayjest\ViewComponents\Components\Html;

use Nayjest\ViewComponents\BaseComponents\Html\AbstractTag;

class Input extends AbstractTag
{
    public function getTagName()
    {
        return 'input';
    }
}
