<?php
namespace Presentation\Framework\Component;

use Nayjest\Manipulator\Manipulator;
use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Data\DataAcceptorInterface;
use Presentation\Framework\Base\RepeaterInterface;
use Presentation\Framework\Base\RepeaterTrait;
use Presentation\Framework\Rendering\ViewTrait;
use Traversable;

function defaultRepeaterCallback(Repeater $repeater, $dataRow)
{
    foreach($repeater->children() as $component)
    {
        if ($component instanceof DataAcceptorInterface) {
            $component->setData($dataRow);
        } else {
            $writable = Manipulator::getWritable($component);
            $fields = Manipulator::getValues($dataRow, $writable);
            Manipulator::assign($component, $fields);
        }
    }
}

class Repeater implements ComponentInterface, RepeaterInterface
{
    use NodeTrait;
    use ViewTrait;
    use ComponentTrait;
    use RepeaterTrait;

    /**
     * @param array|Traversable $iterator
     * @param \Nayjest\Tree\ChildNodeInterface[] $components
     * @param callable|null $callback receives Repeater as argument1 and row of data as argument 2.
     */
    public function __construct(
        $iterator = null,
        array $components = [],
        callable $callback = null
    )
    {
        if ($callback === null) {
            $callback = '\Presentation\Framework\Component\defaultRepeaterCallback';
        }
        if ($components !== null) {
            $this->children()->set($components);
        }
        $this->setIterator($iterator);
        $this->setCallback($callback);
    }

    protected function renderRow($dataRow)
    {
        if ($this->getCallback() !== null) {
            call_user_func(
                $this->getCallback(),
                $this,
                $dataRow
            );
        }
        return $this->renderChildren();
    }

    public function render()
    {
        $this->emit('render', [$this]);
        $output = '';
        if ($this->iterator) {
            foreach ($this->iterator as $dataRow) {
                $output .= $this->renderRow($dataRow);
            }
        }
        return $output;
    }
}
