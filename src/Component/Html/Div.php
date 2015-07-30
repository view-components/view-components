<?php
namespace Presentation\Framework\Component\Html;

use Presentation\Framework\Base\Html\AbstractTag;

class Div extends AbstractTag
{
    public function getTagName()
    {
        return 'div';
    }
}
