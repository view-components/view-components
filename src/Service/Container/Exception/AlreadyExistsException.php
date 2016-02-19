<?php

namespace ViewComponents\ViewComponents\Service\Container\Exception;

use Interop\Container\Exception\ContainerException;
use RuntimeException;

class AlreadyExistsException extends RuntimeException implements ContainerException
{
}
