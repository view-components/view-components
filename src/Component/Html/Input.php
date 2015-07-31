<?php
namespace Presentation\Framework\Component\Html;

use Presentation\Framework\Base\Html\AbstractTag;

class Input extends AbstractTag
{
    public function getTagName()
    {
        return 'input';
    }
}
