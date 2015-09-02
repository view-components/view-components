<?php

namespace Presentation\Framework\Base;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Rendering\HasTemplateInterface;
use Presentation\Framework\Rendering\HasTemplateTrait;
use Presentation\Framework\Rendering\HasViewDataInterface;
use Presentation\Framework\Rendering\HasViewDataTrait;
use Presentation\Framework\Rendering\RendererInterface;
use Presentation\Framework\Rendering\ViewTrait;

/**
 * Class AbstractTemplateView.
 *
 * The class is a base implementation of component that can render a view template.
 *
 * Derived classes must implement getRenderer() method.
 *
 * The class manages rendering of children components following way:
 * if children was not rendered inside template, they will be rendered after it.
 *
 * @package Presentation\Framework\Base
 */
abstract class AbstractTemplateView implements
    ComponentInterface,
    HasTemplateInterface,
    HasViewDataInterface
{
    use NodeTrait;
    use ViewTrait;
    use ComponentTrait {
        ComponentTrait::renderChildren as private renderChildrenInternal;
    }
    use HasTemplateTrait;
    use HasViewDataTrait;

    private $wasChildrenRendered = false;

    /**
     * Returns renderer.
     *
     * @return RendererInterface
     */
    abstract protected function getRenderer();

    /**
     * Constructor.
     *
     * @param null $template
     * @param array $vars
     */
    public function __construct(
        $template = null,
        array $vars = []
    )
    {
        $this->setTemplate($template);
        $this->setViewData($vars);
    }

    /**
     * Renders template.
     *
     * @return string
     */
    public function renderTemplate()
    {
        return $this->getRenderer()->render(
            $this->resolveTemplate(),
            array_merge(
                $this->getViewData(),
                ['component' => $this]
            )
        );
    }

    public function render()
    {
        $this->wasChildrenRendered = false;
        return $this->beforeRender()->notify()
        . $this->renderTemplate()
        . ($this->wasChildrenRendered ? $this->renderChildren() : '');
    }

    public function renderChildren()
    {
        $this->wasChildrenRendered = true;
        return $this->renderChildrenInternal();
    }
}
