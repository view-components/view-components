<?php
namespace Nayjest\ViewComponents\Components\Html;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\DecoratedContainerTrait;
use Nayjest\ViewComponents\BaseComponents\Html\TagInterface;
use Nayjest\ViewComponents\BaseComponents\Html\TagTrait;

class Tag implements ContainerInterface, TagInterface
{
    use DecoratedContainerTrait;
    use TagTrait;

    const DEFAULT_TAG_NAME = 'div';

    protected $tagName;

    /**
     * @param string|null $tagName
     * @param array|null $attributes
     * @param array|null $components
     */
    public function __construct(
        $tagName = null,
        array $attributes = null,
        array $components = null
    )
    {
        if ($tagName !== null) {
            $this->setTagName($tagName);
        }
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }
        if ($components !== null) {
            $this->setComponents($components);
        }
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
        return $this->tagName ?: static::DEFAULT_TAG_NAME;
    }
}
