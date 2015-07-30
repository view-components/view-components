<?php

namespace Presentation\Framework\Component\Html;

use Presentation\Framework\Base\Html\AbstractTag;

class Label extends AbstractTag
{
    public function getTagName()
    {
        return 'form';
    }
}
