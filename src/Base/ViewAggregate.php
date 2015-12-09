<?php

namespace Presentation\Framework\Base;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Rendering\ViewTrait;

class ViewAggregate implements ComponentInterface
{
    use ComponentTrait;
    use NodeTrait {
        NodeTrait::children as private childrenInternal;
    }
    use ViewTrait;

    /**
     * @var ComponentInterface
     */
    protected $view;

    public function __construct(ComponentInterface $view = null)
    {
        // don't sort children, becouse it always has only one child
        $this->setSortable(false);
        $this->setView($view);
    }

    public function children()
    {
        $children = $this->childrenInternal();
        if (!$this->getView()) {
            $this->useDefaultView();
        }
        return $children;
    }

    /**
     * Override this method to specify default view
     *
     * @return ComponentInterface|null
     */
    protected function makeDefaultView()
    {
        return null;
    }

    /**
     * Returns view component.
     *
     * @param bool $useDefault optional, false by default; pass true to use default view
     * @return ComponentInterface|null
     */
    public function getView($useDefault = false)
    {
        if ($useDefault && $this->view === null) {
            $this->useDefaultView();
        }
        return $this->view;
    }

    /**
     * Sets view component.
     *
     * @param ComponentInterface|null $view
     * @return $this
     */
    public function setView(ComponentInterface $view = null)
    {
        if ($view === $this->view) {
            return $this;
        }
        if ($this->view) {
            $this->view->unlock()->detach();
        }
        $this->view = $view;
        $view && $view->attachTo($this)->lock();
        return $this;
    }

    final public function useDefaultView()
    {
        $view = $this->makeDefaultView();
        if ($view) {
            $this->setView($view);
        }
    }
}
