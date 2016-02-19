<?php
namespace ViewComponents\ViewComponents\Rendering;

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
        $this->useDefaultViewIfNull();
        return $this->view;
    }

    public function render()
    {
        return ($view = $this->getView()) ? $view->render() : '';
    }

    protected final function useDefaultViewIfNull()
    {
        if ($this->view === null) {
            $this->setView($this->makeDefaultView());
        }
    }

    /**
     * @return ViewInterface|null
     */
    abstract protected function makeDefaultView();
}
