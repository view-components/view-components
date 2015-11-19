<?php

namespace Presentation\Framework\Base;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Rendering\ViewTrait;

class ViewAggregate implements ComponentInterface
{
    use ComponentTrait {
        ComponentTrait::render as private renderInternal;
    }
    use NodeTrait;
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
     * @return ComponentInterface|null
     */
    public function getView()
    {
        return $this->view;
    }


    /**
     * @param ComponentInterface|null $view
     * @return $this
     */
    public function setView(ComponentInterface $view = null)
    {
        if ($this->view) {
            $this->view->unlock()->detach();
        }
        $this->view = $view;
        $view->attachTo($this)->lock();
        return $this;
    }

    final public function useDefaultView()
    {
        $this->setView($this->makeDefaultView());
    }

    public function render()
    {
        if (!$this->getView()) {
            $this->useDefaultView();
        }
        return $this->renderInternal();
    }
}
