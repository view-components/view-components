<?php

namespace Presentation\Framework\Event;

use Presentation\Framework\Base\ComponentInterface;
use SplObjectStorage;
use SplObserver;
use SplSubject;

class Observable implements SplSubject
{
    private $storage;

    private $subject;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function attach(SplObserver $observer)
    {
        $this->getStorage()->attach($observer);
    }

    public function attachCallback(callable $callback)
    {
        $this->attach(new CallbackObserver($callback));
    }

    public function detach(SplObserver $observer)
    {
        $this->getStorage()->detach($observer);
    }

    /**
     * @return ComponentInterface
     */
    public function getSubject()
    {
        return $this->subject;
    }
    /**
     * @return string
     */
    public function notify()
    {
        $output = '';
        if (!$this->storage) {
            return '';
        }
        /** @var AbstractObserver $observer */
        foreach ($this->storage as $observer) {
            $result = $observer->update($this);
            if (null !== $result) {
                $output .= $result;
            }
        }
        return $output;
    }

    private function getStorage()
    {
        if ($this->storage === null) {
            $this->storage = new SplObjectStorage();
        }
        return $this->storage;
    }
}
