<?php
namespace Presentation\Framework\Base;

use Nayjest\Collection\Extended\ObjectCollectionInterface;
use Presentation\Framework\Rendering\ViewInterface;
use Presentation\Framework\Rendering\ViewTrait;

trait ViewComponentTrait
{
    use ViewTrait;
    use HasSortPositionTrait;

    abstract public function on($event, callable $listener);
    abstract public function emit($event, array $arguments = []);
    abstract protected function doRender();

    private $visible = true;

    final public function render()
    {
        $this->emit('render', [$this]);
        if (!$this->isVisible()) {
            return '';
        }
        return $this->doRender();
    }

    final public function onRender(callable $callback)
    {
        $this->on('render', $callback);
        return $this;
    }

    public function hide()
    {
        $this->visible = false;
        return $this;
    }

    public function show()
    {
        $this->visible = true;
        return $this;
    }

    public function setVisible($value)
    {
        $this->visible = $value;
        return $this;
    }

    public function isVisible()
    {
        return $this->visible;
    }
}
