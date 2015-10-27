<?php

namespace Presentation\Framework\Base;

use Nayjest\Tree\ReadonlyNodeTrait;
use Presentation\Framework\Rendering\ViewTrait;

class ViewAggregate implements ComponentInterface
{

    use ComponentTrait;
    use ReadonlyNodeTrait;
    use ViewTrait;

    public function __construct(ComponentInterface $view = null)
    {
        // don't sort children, becouse it always has only one child
        $this->setSortable(false);
        $this->setView($view);
    }

    /**
     * @return ComponentInterface
     */
    public function getView()
    {
        return $this->writableChildren()->first();
    }

    /**
     * @param mixed $viewComponent
     */
    public function setView(ComponentInterface $viewComponent)
    {
        $this->writableChildren()->set([$viewComponent]);
    }
}