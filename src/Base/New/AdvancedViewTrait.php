<?php
namespace Presentation\Framework\Base;

use Presentation\Framework\Rendering\ViewTrait;

/**
 * Trait for renderable components.
 * Added in v0.19
 */
trait AdvancedViewTrait
{
    use ViewTrait;
    use VisibilityTrait;
    use HasSortPositionTrait;

    abstract public function on($event, callable $listener);
    abstract public function emit($event, array $arguments = []);

    abstract protected function renderInternal();

    final public function render()
    {
        $begin = $this->prepareForRender();
        if ($begin === false) {
            return '';
        }
        return $this->finalizeRender($this->renderInternal());
    }

    final public function beforeRender(callable $callback)
    {
        $this->on('before_render', $callback);
        return $this;
    }

    final public function afterRender(callable $callback)
    {
        $this->on('after_render', $callback);
        return $this;
    }

    /**
     * If returns false, rendering will be canceled
     * @return bool
     */
    protected function prepareForRender()
    {
        $this->emit('before_render', [$this]);
        return $this->isVisible();
    }

    protected function finalizeRender($output)
    {
        $this->emit('after_render', [$this]);
        return $output;
    }
}
