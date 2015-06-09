<?php

namespace Nayjest\ViewComponents\Components\Html;

use Nayjest\ViewComponents\BaseComponents\Html\AbstractTag;

class Label extends AbstractTag
{
    public function getTagName()
    {
        return 'form';
    }
}
