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

    /**
     * Attaches handler for 'render' event.
     *
     * @param callable $callback
     * @return $this
     */
    public function onRender(callable $callback);

    /**
     *  Hides component.
     *
     *  Method acts same way like calling  $component->setVisible(false)
     *
     * @return $this
     */
    public function hide();

    /**
     * Shows component (if hidden).
     *
     * Method acts same way like calling  $component->setVisible(true)
     */
    public function show();

    /**
     * Sets component visibility.
     *
     * @param bool $value
     * @return $this
     */
    public function setVisible($value);

    /**
     * Returns `true` if component is visible and `false` otherwise.
     *
     * @return bool
     */
    public function isVisible();
}
