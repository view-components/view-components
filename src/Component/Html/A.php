<?php
namespace Presentation\Framework\Component\Html;

use Presentation\Framework\Base\Html\AbstractTag;

class A extends AbstractTag
{
    public function getTagName()
    {
        return 'a';
    }
}
