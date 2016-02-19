<?php

namespace ViewComponents\ViewComponents\Rendering;

/**
 * Trait HasViewData.
 *
 */
trait HasViewDataTrait
{
    protected $viewData = [];

    /**
     * Returns data that must be passed to view.
     *
     * @return array
     */
    public function getViewData()
    {
        return $this->viewData;
    }

    /**
     * Sets data that must be passed to view.
     *
     * @param array $viewData
     * @return $this
     */
    public function setViewData(array $viewData = [])
    {
        $this->viewData = $viewData;
        return $this;
    }
}
