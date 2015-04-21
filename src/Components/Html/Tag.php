<?php
namespace Nayjest\ViewComponents\Components\Html;

use Nayjest\ViewComponents\BaseComponents\Container as BaseContainer;
use Nayjest\ViewComponents\BaseComponents\Html\TagTrait;

class Tag extends BaseContainer
{
    const DEFAULT_TAG_NAME = 'div';

    use TagTrait;

    protected $tag_name;

    /**
     * @param string|null $tagName
     * @param array|null $attributes
     * @param array $components
     */
    public function __construct(
        $tagName = null,
        $attributes = null,
        array $components = []
    )
    {
        if ($tagName !== null) {
            $this->setTagName($tagName);
        }
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }
        parent::__construct($components);
    }

    /**
     * Allows to specify HTML tag.
     *
     * @param string $name
     * @return $this
     */
    public function setTagName($name)
    {
        $this->tag_name = $name;
        return $this;
    }

    /**
     * Returns HTML tag.
     *
     * @return string
     */
    public function getTagName()
    {
        return $this->tag_name ? : static::DEFAULT_TAG_NAME;
    }
}
