<?php
namespace Nayjest\ViewComponents\Common;

use LogicException;

trait InitializedOnceTrait
{

    protected $initialized = false;

    protected function setInitialized()
    {
        if ($this->initialized) {
            throw new LogicException(
                'Object initialization performed more than once.'
            );
        }
        $this->initialized = true;
    }

    protected function checkInitialized()
    {
        if ($this->initialized === false) {
            throw new LogicException(
                'Calling method that requires object initialization '
                . 'while it\'s not initialized.'
            );
        }
    }

    protected function checkNotInitialized()
    {
        if ($this->initialized === true) {
            throw new LogicException(
                'Calling method that isn\'t allowed after initialization.'
            );
        }
    }
}
