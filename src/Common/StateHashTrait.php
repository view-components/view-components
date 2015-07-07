<?php

namespace Presentation\Framework\Common;

trait StateHashTrait
{
    public function getStateHash()
    {
        return md5(serialize($this));
    }
}
