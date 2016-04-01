<?php

namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentTrait;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;

/**
 * ViewAggregate is a component that delegates it's rendering to aggregated view component.
 *
 * It's a good candidate for extending to component classes that holds logic.
 *
 */
class ViewAggregate implements ContainerComponentInterface
{
    use ContainerComponentTrait;

    /** @var  ViewComponentInterface|null */
    private $view;

    /**
     * Constructor.
     *
     * @param ViewComponentInterface|null $view
     */
    public function __construct(ViewComponentInterface $view = null)
    {
        $this->setView($view);
    }

    /**
     * Returns view component.
     *
     * @return ViewComponentInterface|null
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Sets view component.
     *
     * @param ViewComponentInterface $view
     * @return $this
     */
    public function setView(ViewComponentInterface $view = null)
    {
        if ($view === $this->view) {
            return $this;
        }
        $this->view && $this->view->detach();
        $view && $view->attachTo($this);
        $this->view = $view;
        return $this;
    }

    /**
     * Renders component and returns output.
     *
     * @return string
     */
    public function render()
    {
        return $this->renderChildren();
    }
}
