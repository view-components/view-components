<?php
namespace Nayjest\ViewComponents\Components\Base;

use Nayjest\ViewComponents\Rendering\ParentViewInterface;
use Nayjest\ViewComponents\Rendering\ParentViewTrait;
use Nayjest\ViewComponents\Structure\ParentInterface;
use Nayjest\ViewComponents\Structure\ParentTrait;

abstract class Container extends Component implements
    ParentViewInterface,
    ParentInterface
{
    use ParentTrait;
    use ParentViewTrait;

    abstract protected function renderOpening();

    abstract protected function renderClosing();

    public function __construct(array $components = [])
    {
        if (count($components) > 0) {
            $this->components()->set($components);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->renderOpening()
        . $this->renderComponents()
        . $this->renderClosing();
    }
}
