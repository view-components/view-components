<?php

namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentTrait;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;

/**
 * ViewAggregate is a component that aggregates view.
 *
 * It's a good candidate for extending to component classes that holds logic.
 *
 */
class ViewAggregate implements ContainerComponentInterface
{
    use ContainerComponentTrait;

    /** @var  ViewComponentInterface|null */
    private $view;

    public function __construct(ViewComponentInterface $view = null)
    {
        $this->setView($view);
    }

    /**
     * @return ViewComponentInterface|null
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param ViewComponentInterface $view
     * @return $this
     */
    public function setView(ViewComponentInterface $view = null)
    {
        if ($view === $this->view) {
            return $this;
        }
        $this->view && $this->view->unlock()->detach();
        $view && $view->attachTo($this)->lock();
        $this->view = $view;
        return $this;
    }

    public function render()
    {
        return $this->renderChildren();
    }
}
