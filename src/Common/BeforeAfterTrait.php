<?php
namespace Presentation\Framework\Common;

trait BeforeAfterTrait
{
    protected $beforeCallbacks = [];
    protected $afterCallbacks = [];

    public function before(callable $callback)
    {
        $this->beforeCallbacks[] = $callback;
    }

    public function after(callable $callback)
    {
        $this->afterCallbacks[] = $callback;
    }

    protected function runBeforeCallbacks(array $arguments = [])
    {
        return $this->runCallbacks($this->beforeCallbacks, $arguments);
    }

    protected function runAfterCallbacks(array $arguments = [])
    {
        return $this->runCallbacks($this->afterCallbacks, $arguments);
    }

    private function runCallbacks($callbacks, $arguments)
    {
        foreach($callbacks as $callback) {
            if (false === call_user_func_array($callback, $arguments))
            {
                return false;
            }
        }
        return true;
    }
}
