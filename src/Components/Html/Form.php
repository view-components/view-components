<?php
namespace Nayjest\ViewComponents\Components\Html;

use Nayjest\ViewComponents\BaseComponents\Html\AbstractTag;

class Form extends AbstractTag
{
    public function getTagName()
    {
        return 'form';
    }
}
