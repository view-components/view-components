<?php
namespace Nayjest\ViewComponents\Common;

use LogicException;

trait InitializedOnceTrait
{

    protected $isInitialized = false;

    protected function setIsInitialized()
    {
        if ($this->isInitialized) {
            throw new LogicException(
                'Object initialization performed more than once.'
            );
        }
        $this->isInitialized = true;
    }

    protected function checkInitialized()
    {
        if ($this->isInitialized === false) {
            throw new LogicException(
                'Calling method that requires object initialization '
                . 'while it\'s not initialized.'
            );
        }
    }
}
