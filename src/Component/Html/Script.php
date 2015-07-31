<?php
namespace Presentation\Framework\Component\Html;

use Presentation\Framework\Base\Html\AbstractTag;

class Script extends AbstractTag
{
    public function getTagName()
    {
        return 'script';
    }
}
