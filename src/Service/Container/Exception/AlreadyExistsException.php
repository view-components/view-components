<?php

namespace Presentation\Framework\Service\Container\Exception;

use Interop\Container\Exception\ContainerException;
use RuntimeException;

class AlreadyExistsException extends RuntimeException implements ContainerException
{
}
