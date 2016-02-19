<?php

namespace ViewComponents\ViewComponents\Common;

trait StateHashTrait
{
    public function getStateHash()
    {
        return md5(serialize($this));
    }
}
