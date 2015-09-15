<?php
namespace Presentation\Framework\Customization;

use Presentation\Framework\Base\ComponentInterface;

class ConfigurableCustomization extends AbstractRecursiveCustomization
{
    protected $callbacks = [];

    public function register($class, callable $callback)
    {
        if (!array_key_exists($class, $this->callbacks)) {
            $this->callbacks[$class] = [];
        }
        $this->callbacks[$class][] = $callback;
        return $this;
    }

    protected function applyInternal(ComponentInterface $component)
    {
        foreach($this->callbacks as $class => $callbacks)
        {
            if ($component instanceof $class) {
                foreach($callbacks as $cb) {
                    call_user_func($cb, $component);
                }
            }
        }
    }
}
