<?php
namespace Presentation\Framework\Base\Html;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\DecoratedContainerTrait;
use Presentation\Framework\Rendering\ViewTrait;

/**
 * Class AbstractTag
 *
 * Base class for html tags.
 * Class name must same as tag name.
 */
abstract class AbstractTag implements ComponentInterface, TagInterface
{
    use NodeTrait;
    use ViewTrait;
    use DecoratedContainerTrait;
    use TagTrait;

    /**
     * @param array|null $attributes
     * @param array|\Traversable|null $components
     */
    public function __construct(
        array $attributes = [],
        $components = null
    )
    {
        $this->setAttributes($attributes);
        if ($components) {
            $this->children()->set($components);
        }
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
