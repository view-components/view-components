<?php

namespace ViewComponents\ViewComponents\Base\Html;

trait AutoSubmittingInputTrait
{
    /** @var  $autoSubmitting */
    private $autoSubmitting = false;

    abstract protected function onAutoSubmittingValueChange();

    /**
     * Sets auto-submitting option value.
     *
     * If auto-submitting turned on, form will be submitted automatically on input value change.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function setAutoSubmitting($value)
    {
        if ($this->autoSubmitting !== (bool)$value) {
            $this->autoSubmitting = (bool)$value;
            $this->onAutoSubmittingValueChange();
        }
        return $this;
    }

    /**
     * Returns auto-submitting option value.
     *
     * If auto-submitting turned on, form will be submitted automatically on input value change.
     *
     * @return bool
     */
    public function getAutoSubmitting()
    {
        return $this->autoSubmitting;
    }

    /**
     * Returns true if auto-submitting turned on.
     *
     * If auto-submitting turned on, form will be submitted automatically on input value change.
     * @return bool
     */
    public function isAutoSubmitted()
    {
        return $this->autoSubmitting === true;
    }

    /**
     * Enables auto-submitting.
     *
     * @return $this
     */
    public function enableAutoSubmitting()
    {
        if ($this->autoSubmitting === false) {
            $this->autoSubmitting = true;
            $this->onAutoSubmittingValueChange();
        }
        return $this;
    }

    /**
     * Disables auto-submitting.
     *
     * @return $this
     */
    public function disableAutoSubmitting()
    {
        if ($this->autoSubmitting === true) {
            $this->autoSubmitting = false;
            $this->onAutoSubmittingValueChange();
        }
        return $this;
    }
}
