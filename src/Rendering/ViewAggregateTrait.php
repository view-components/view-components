<?php
namespace Nayjest\ViewComponents\Rendering;

trait ViewAggregateTrait
{
    protected $view;

    /**
     * @param ViewInterface $view
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * @return ViewInterface|null
     */
    public function getView()
    {
        if ($this->view === null) {
            $this->view = $this->makeDefaultView();
        }
        return $this->view;
    }

    public function render()
    {
        return ($view = $this->getView()) ? $view->render() : '';
    }

    abstract protected function makeDefaultView();
}