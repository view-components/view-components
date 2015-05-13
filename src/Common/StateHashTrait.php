<?php

namespace Nayjest\ViewComponents\Common;

trait StateHashTrait
{
    public function getStateHash()
    {
        return md5(serialize($this));
    }
}
