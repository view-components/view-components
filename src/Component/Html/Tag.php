<?php
namespace Presentation\Framework\Component\Html;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\DecoratedContainerTrait;
use Presentation\Framework\Base\Html\TagInterface;
use Presentation\Framework\Base\Html\TagTrait;
use Presentation\Framework\Rendering\ViewTrait;
use Traversable;

class Tag implements ComponentInterface, TagInterface
{
    use ViewTrait;
    use NodeTrait;
    use DecoratedContainerTrait;
    use TagTrait;

    const DEFAULT_TAG_NAME = 'div';

    protected $tagName;

    /**
     * @param string|null $tagName
     * @param array|null $attributes
     * @param array|Traversable|null $components
     */
    public function __construct(
        $tagName = null,
        array $attributes = null,
        $components = null
    )
    {
        if ($tagName !== null) {
            $this->setTagName($tagName);
        }
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }
        if ($components !== null) {
            $this->children()->set($components);
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
