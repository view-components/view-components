<?php
namespace Presentation\Framework\Components\Html;

use Presentation\Framework\BaseComponents\Html\AbstractTag;

class Input extends AbstractTag
{
    public function getTagName()
    {
        return 'input';
    }
}
