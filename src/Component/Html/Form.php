<?php
namespace Presentation\Framework\Component\Html;

use Presentation\Framework\Base\Html\AbstractTag;

class Form extends AbstractTag
{
    public function getTagName()
    {
        return 'form';
    }
}
