<?php

namespace ViewComponents\ViewComponents\Exceptions;

use Exception;
use RuntimeException;

/**
 * Class ProcessorNotFoundException
 * @todo "Exceptions" namespace isn't correct
 */
class ProcessorNotFoundException extends RuntimeException
{
    protected $operation;

    public function __construct(
        $operationClass = null,
        $resolverClass = null,
        Exception $previous = null
    ) {
        $code = 0;
        $message = 'Processor not found for target operation.';
        if ($operationClass !== null) {
            $message .= PHP_EOL . "Operation: $operationClass.";
        }
        if ($resolverClass !== null) {
            $message .= PHP_EOL . "Processor resolver: $resolverClass.";
        }
        parent::__construct($message, $code, $previous);
    }
}
