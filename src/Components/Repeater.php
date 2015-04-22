<?php
namespace Nayjest\ViewComponents\Components;

use Nayjest\ViewComponents\BaseComponents\Component;
use Nayjest\ViewComponents\Data\RepeaterInterface;
use Nayjest\ViewComponents\Data\RepeaterTrait;
use Nayjest\ViewComponents\Rendering\ParentViewInterface;
use Nayjest\ViewComponents\Rendering\ParentViewTrait;
use Nayjest\ViewComponents\Structure\ParentInterface;
use Nayjest\ViewComponents\Structure\ParentTrait;
use Traversable;

class Repeater extends Component implements
    ParentViewInterface,
    ParentInterface,
    RepeaterInterface
{
    use ParentTrait;
    use ParentViewTrait;
    use RepeaterTrait;

    public static function defaultCallback(Repeater $repeater, $dataRow)
    {
        $repeater->components()->fillItemsWith($dataRow);
    }

    /**
     * @param array|Traversable $iterator
     * @param \Nayjest\ViewComponents\Structure\ChildInterface[] $components
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
