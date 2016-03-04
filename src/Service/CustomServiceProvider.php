<?php

namespace ViewComponents\ViewComponents\Service;

class CustomServiceProvider implements ServiceProviderInterface
{
    private $registrationFunction;

    /**
     * CustomServiceProvider constructor.
     * @param callable|null $registerFunction
     */
    public function __construct(callable $registerFunction = null)
    {
        $this->registrationFunction = $registerFunction;
    }

    /**
     * Registers presentation framework core services on the given container.
     *
     * @param ServiceContainer $container container instance
     */
    public function register(ServiceContainer $container)
    {
        if ($this->registrationFunction !== null) {
            call_user_func($this->registrationFunction, $container);
        }
    }

    /**
     * @param callable $registrationFunction
     * @return $this
     */
    public function setRegistrationFunction(callable $registrationFunction)
    {
        $this->registrationFunction = $registrationFunction;
        return $this;
    }
}
