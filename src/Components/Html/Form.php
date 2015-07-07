<?php
namespace Presentation\Framework\Components\Html;

use Presentation\Framework\BaseComponents\Html\AbstractTag;

class Form extends AbstractTag
{
    public function getTagName()
    {
        return 'form';
    }
}
