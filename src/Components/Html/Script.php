<?php
namespace Nayjest\ViewComponents\Components\Html;

use Nayjest\ViewComponents\BaseComponents\Html\AbstractTag;

class Script extends AbstractTag
{
    public function getTagName()
    {
        return 'script';
    }
}
