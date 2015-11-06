<?php

namespace Presentation\Framework\Base;

use Nayjest\Tree\ReadonlyNodeTrait;
use Presentation\Framework\Rendering\ViewTrait;

class ViewAggregate implements ComponentInterface
{
    use ComponentTrait {
        ComponentTrait::render as private renderInternal;
    }
    use ReadonlyNodeTrait;
    use ViewTrait;

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
        return $this->writableChildren()->first();
    }


    /**
     * @param ComponentInterface|null $viewComponent
     * @return $this
     */
    public function setView(ComponentInterface $viewComponent = null)
    {
        if ($viewComponent === null) {
            $this->writableChildren()->clear();
        } else {
            $this->writableChildren()->set([$viewComponent]);
        }
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
