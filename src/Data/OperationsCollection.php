<?php
namespace Nayjest\ViewComponents\Data;


use Nayjest\ViewComponents\Structure\AbstractCollection;

class OperationsCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getStateKey()
    {
        return md5(serialize($this));
    }
}
