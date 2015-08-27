<?php

namespace Presentation\Framework\Event;


trait BeforeRenderTrait
{
    private $beforeRenderObservable;

    /**
     * @return Observable
     */
    public function beforeRender()
    {
        if ($this->beforeRenderObservable === null) {
            $this->beforeRenderObservable = new Observable($this);
        }
        return $this->beforeRenderObservable;
    }
}
