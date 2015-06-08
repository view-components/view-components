<?php

namespace Nayjest\ViewComponents\Exceptions;

use Exception;
use RuntimeException;

class ProcessorNotFoundException extends RuntimeException
{
    public function __construct(
        $message = 'Processor not found for target operation.',
        $code = 0,
        Exception $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
