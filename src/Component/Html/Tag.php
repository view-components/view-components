<?php
namespace ViewComponents\ViewComponents\Component\Html;

use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentTrait;
use ViewComponents\ViewComponents\Base\Html\TagInterface;
use ViewComponents\ViewComponents\Base\Html\TagTrait;
use Traversable;

class Tag implements ContainerComponentInterface, TagInterface
{
    use ContainerComponentTrait;
    use TagTrait;

    /** @var  string */
    private $tagName;

    /**
     * @param string $tagName html tag name, optional, default value: 'div'
     * @param array $attributes html tag attributes, optional
     * @param array|Traversable $components child components (will be rendered inside tag) empty by default
     */
    public function __construct(
        $tagName = 'div',
        array $attributes = [],
        $components = []
    ) {
        $this->setTagName($tagName);
        $this->setAttributes($attributes);
        $this->children()->set($components);
    }

    /**
     * Allows to specify HTML tag name.
     *
     * @param string $name
     * @return $this
     */
    public function setTagName($name)
    {
        $this->tagName = $name;
        return $this;
    }

    /**
     * Returns HTML tag name.
     *
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * Renders component and returns output.
     *
     * @return string
     */
    public function render()
    {
        return $this->renderOpening() . $this->renderChildren() . $this->renderClosing();
    }
}
