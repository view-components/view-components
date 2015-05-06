<?php
namespace Nayjest\ViewComponents\Data;


use Nayjest\ViewComponents\Collection\Collection;

class OperationsCollection extends Collection
{
    /**
     * @return string
     */
    public function getStateKey()
    {
        return md5(serialize($this));
    }
}
