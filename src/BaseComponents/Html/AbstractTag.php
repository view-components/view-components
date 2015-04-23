<?php
namespace Nayjest\ViewComponents\BaseComponents\Html;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\ContainerTrait;

/**
 * Class AbstractTag
 *
 * Base class for html tags.
 * Class name must same as tag name.
 */
abstract class AbstractTag implements ContainerInterface, TagInterface
{
    use ContainerTrait;
    use TagTrait;

    /**
     * @param array|null $attributes
     * @param array $components
     */
    public function __construct(
        array $attributes = null,
        array $components = null
    )
    {
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }
        if ($components !== null) {
            $this->setComponents($components);
        }
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
