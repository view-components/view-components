<?php

namespace ViewComponents\ViewComponents\Service\Exception;

use Interop\Container\Exception\ContainerException;
use RuntimeException;

class AlreadyExistsException extends RuntimeException implements ContainerException
{
}
