<?php
namespace Nayjest\ViewComponents\BaseComponents\Html;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\DecoratedContainerTrait;

/**
 * Class AbstractTag
 *
 * Base class for html tags.
 * Class name must same as tag name.
 */
abstract class AbstractTag implements ContainerInterface, TagInterface
{
    use DecoratedContainerTrait;
    use TagTrait;

    /**
     * @param array|null $attributes
     * @param array $components
     */
    public function __construct(
        array $attributes = [],
        array $components = []
    )
    {
        $this->setAttributes($attributes);
        $this->setComponents($components);
    }

    /**
     * Returns HTML tag name based on class name.
     *
     * @return string
     */
    public function getTagName()
    {
        return $this->suggestTagByClassName();
    }

    protected function suggestTagByClassName()
    {
        $class_name = get_class($this);
        $parts = explode('\\', $class_name);
        $base_name = array_pop($parts);
        return strtolower($base_name);
    }
}
