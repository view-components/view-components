<?php
namespace Presentation\Framework\Components\Html;

use Presentation\Framework\BaseComponents\Html\AbstractTag;

class Script extends AbstractTag
{
    public function getTagName()
    {
        return 'script';
    }
}
