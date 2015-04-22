<?php
namespace Nayjest\ViewComponents\Data;

trait RepeaterTrait
{
    protected $iterator;

    protected $callback;

    public function setIterator($iterator)
    {
        $this->iterator = $iterator;
        return $this;
    }

    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * @param callable|null $callback
     * @return $this
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    public function getCallback()
    {
        return $this->callback;
    }
}
