<?php

namespace Presentation\Framework\Exceptions;

use Exception;
use RuntimeException;

class NonExistingGroupException extends RuntimeException
{
    public function __construct(
        $message = 'Object does\'nt have target group.',
        $code = 0,
        Exception $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
