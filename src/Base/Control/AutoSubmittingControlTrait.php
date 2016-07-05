<?php

namespace ViewComponents\ViewComponents\Base\Control;

use RuntimeException;
use ViewComponents\ViewComponents\Base\Html\AutoSubmittingInputInterface;
use ViewComponents\ViewComponents\Base\Html\AutoSubmittingInputTrait;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Component\TemplateView;

trait AutoSubmittingControlTrait
{
    use AutoSubmittingInputTrait;

    /**
     * Note that this trait is suitable only for controls derived from ViewAggregate
     * (ViewAggregate->Part->[ConcreteControl]).
     *
     * @return ViewComponentInterface
     */
    abstract public function getView();

    public function setView(ViewComponentInterface $view = null)
    {
        parent::setView($view);
        $this->onAutoSubmittingValueChange();
        return $this;
    }

    /**
     * This method is used by root component (e.g. ManagedList)
     * to determine that submit button should be present.
     *
     * @see \ViewComponents\ViewComponents\Component\ManagedList::hideSubmitButtonIfNotUsed
     * @see \ViewComponents\ViewComponents\Base\Control\ControlInterface::isManualFormSubmitRequired
     *
     * @return bool
     */
    public function isManualFormSubmitRequired()
    {
        return !$this->isAutoSubmitted();
    }

    protected function onAutoSubmittingValueChange()
    {
        $view = $this->getView();
        if ($view instanceof AutoSubmittingInputInterface) {
            $view->setAutoSubmitting($this->getAutoSubmitting());
            return;
        }
        if ($view instanceof TemplateView) {
            if ($view->setDataItem('autoSubmit', $this->getAutoSubmitting())) {
                return;
            }
        }
        if ($view === null) {
            return;
        }
        throw new RuntimeException('Aggregated view does not supports auto-submitting');
    }
}
