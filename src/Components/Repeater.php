<?php
namespace Nayjest\ViewComponents\Components;

use Nayjest\ViewComponents\BaseComponents\AbstractComponent;
use Nayjest\ViewComponents\Data\RepeaterInterface;
use Nayjest\ViewComponents\Data\RepeaterTrait;
use Nayjest\ViewComponents\Rendering\ParentViewInterface;
use Nayjest\ViewComponents\Rendering\ParentViewTrait;
use Nayjest\ViewComponents\Structure\ParentNodeInterface;
use Nayjest\ViewComponents\Structure\ParentNodeTrait;
use Traversable;

class Repeater extends AbstractComponent implements
    ParentViewInterface,
    ParentNodeInterface,
    RepeaterInterface
{
    use ParentNodeTrait;
    use ParentViewTrait;
    use RepeaterTrait;

    public static function defaultCallback(Repeater $repeater, $dataRow)
    {
        $repeater->components()->fillItemsWith($dataRow);
    }

    /**
     * @param array|Traversable $iterator
     * @param \Nayjest\ViewComponents\Structure\ChildNodeInterface[] $components
     * @param $callback
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
