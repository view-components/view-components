<?php
namespace Presentation\Framework\Base;

use Nayjest\Tree\NodeInterface;
use Presentation\Framework\Rendering\ViewInterface;

interface ComponentInterface extends NodeInterface, ViewInterface
{
    /**
     * @return string
     */
    public function renderChildren();

    /**
     * @return string|null
     */
    public function getComponentName();

    /**
     * @param string|null $componentName
     * @return $this
     */
    public function setComponentName($componentName);

    /**
     * @return bool
     */
    public function isSortable();

    /**
     * @param bool|true $value
     */
    public function setSortable($value = true);

    /**
     * @return int
     */
    public function getSortPosition();

    /**
     * @param int $sortPosition
     * @return $this
     */
    public function setSortPosition($sortPosition);

    public function onRender(callable $callback);
}
