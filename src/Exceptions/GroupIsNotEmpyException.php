<?php

namespace Nayjest\ViewComponents\Exceptions;

use Exception;
use RuntimeException;

class GroupIsNotEmptyException extends RuntimeException
{
    public function __construct(
        $message = 'Trying to remove group that isn\'t empty.',
        $code = 0,
        Exception $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
