<?php

namespace Presentation\Framework\Event;

class CallbackObserver extends AbstractObserver
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }
    
    protected function updateInternal(Observable $observable)
    {
        call_user_func($this->callback, $observable->getSubject());
    }
}
