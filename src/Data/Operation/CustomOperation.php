<?php

namespace ViewComponents\ViewComponents\Data\Operation;

class CustomOperation implements OperationInterface
{
    /**
     * @var callable
     */
    private $callback;
    /**
     * @var array
     */
    private $arguments;

    public function __construct(callable $callback = null, array $arguments = [])
    {
        $this->callback = $callback;
        $this->arguments = $arguments;
    }

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param callable $callback
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }
}
