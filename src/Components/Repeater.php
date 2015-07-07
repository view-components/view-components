<?php
namespace Presentation\Framework\Components;

use Presentation\Framework\BaseComponents\ContainerInterface;
use Presentation\Framework\BaseComponents\ContainerTrait;
use Presentation\Framework\Data\RepeaterInterface;
use Presentation\Framework\Data\RepeaterTrait;
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
     * @param \Presentation\Framework\Structure\ChildNodeInterface[] $components
     * @param callable|null $callback receives Repeater as argument1 and row of data as argument 2.
     */
    public function __construct(
        $iterator = null,
        array $components = [],
        callable $callback = null
    )
    {
        if ($callback === null) {
            $callback = [
                'Presentation\Framework\Components\Repeater',
                'defaultCallback'
            ];
        }
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
