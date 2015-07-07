<?php
namespace Presentation\Framework\Components\Html;

use Presentation\Framework\BaseComponents\Html\AbstractTag;

class A extends AbstractTag
{
    public function getTagName()
    {
        return 'a';
    }
}
