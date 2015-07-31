<?php

namespace Presentation\Framework\Control;

use Presentation\Framework\Base\ComponentInterface;

trait ControlTrait
{

    protected $view;

    abstract protected function makeDefaultView();

    /**
     * @return ComponentInterface
     */
    public function getView()
    {
        if ($this->view === null) {
            $this->view = $this->makeDefaultView();
        }
        return $this->view;
    }

    /**
     * @param ComponentInterface $view
     * @return $this
     */
    public function setView(ComponentInterface $view)
    {
        $this->view = $view;
        return $this;
    }
}
