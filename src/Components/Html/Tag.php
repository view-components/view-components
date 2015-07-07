<?php
namespace Presentation\Framework\Components\Html;

use Presentation\Framework\BaseComponents\ContainerInterface;
use Presentation\Framework\BaseComponents\DecoratedContainerTrait;
use Presentation\Framework\BaseComponents\Html\TagInterface;
use Presentation\Framework\BaseComponents\Html\TagTrait;

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
