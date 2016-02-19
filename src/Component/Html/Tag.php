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

    private $tagName;

    /**
     * @param string|null $tagName
     * @param array|null $attributes
     * @param array|Traversable|null $components
     */
    public function __construct(
        $tagName = 'div',
        array $attributes = [],
        $components = []
    )
    {
        $this->setTagName($tagName);
        $this->setAttributes($attributes);
        $this->children()->set($components);
    }

    /**
     * Allows to specify HTML tag.
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
     * Returns HTML tag.
     *
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    public function render()
    {
        return $this->renderOpening() . $this->renderChildren() . $this->renderClosing();
    }
}
