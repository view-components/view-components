<?php
namespace Nayjest\ViewComponents\Components;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\ContainerTrait;
use Nayjest\ViewComponents\Data\RepeaterInterface;
use Nayjest\ViewComponents\Data\RepeaterTrait;
use Traversable;

class Repeater implements
    ContainerInterface,
    RepeaterInterface
{
    use ContainerTrait;
    use RepeaterTrait;

    public static function defaultCallback(Repeater $repeater, $dataRow)
    {
        $repeater->components()->fillItemsWith($dataRow);
    }

    /**
     * @param array|Traversable $iterator
     * @param \Nayjest\ViewComponents\Structure\ChildNodeInterface[] $components
     * @param callable $callback receives Repeater as argument1 and row of data as argument 2.
     */
    public function __construct(
        $iterator = null,
        array $components = [],
        $callback = [
            'Nayjest\ViewComponents\Components\Repeater',
            'defaultCallback'
        ]
    )
    {
        $this->setComponents($components);
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
        return $this->renderComponents(null);
    }

    public function render()
    {
        $output = '';
        if ($this->iterator) {
            foreach ($this->iterator as $dataRow) {
                $output .= $this->renderRow($dataRow);
            }
        }
        return $output;
    }
}
