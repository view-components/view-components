<?php

namespace Presentation\Framework\Event;

use InvalidArgumentException;
use SplObserver;
use SplSubject;

abstract class AbstractObserver implements SplObserver
{
    abstract protected function updateInternal(Observable $observable);

    public function update(SplSubject $subject)
    {
        if (!$subject instanceof Observable) {
            $expected = Observable::class;
            $actual = get_class($subject);
            $method = get_class($this) . '::update()';

            throw new InvalidArgumentException(
                "$method expects instance of $expected, instance of $actual given."
            );
        }
        return $this->updateInternal($subject);
    }
}
