<?php
namespace Nayjest\ViewComponents\BaseComponents\Html;

use Nayjest\ViewComponents\BaseComponents\AbstractContainer;

/**
 * Class AbstractTag
 *
 * Base class for html tags.
 * Class name must same as tag name.
 *
 * @package Nayjest\ViewComponents\Components\Html
 */
abstract class AbstractTag extends AbstractContainer
{
   use TagTrait;

    /**
     * @param array|null $attributes
     * @param array $components
     */
    public function __construct(
        $attributes = null,
        array $components = []
    )
    {
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }
        parent::__construct($components);
    }

    /**
     * Returns HTML tag name based on class name.
     *
     * @return string
     */
    public function getTagName()
    {
        $class_name = get_class($this);
        $parts = explode('\\', $class_name);
        $base_name = array_pop($parts);
        return strtolower($base_name);
    }
}
