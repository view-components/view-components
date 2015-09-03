<?php
namespace Presentation\Framework\Base;

use Nayjest\Tree\NodeInterface;
use Presentation\Framework\Event\Observable;
use Presentation\Framework\Rendering\ViewInterface;

interface ComponentInterface extends NodeInterface, ViewInterface
{
    /**
     * @return string
     */
    public function renderChildren();

    /**
     * @return Observable
     */
    public function beforeRender();

    /**
     * @return string|null
     */
    public function getComponentName();
}
