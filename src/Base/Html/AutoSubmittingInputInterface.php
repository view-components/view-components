<?php

namespace ViewComponents\ViewComponents\Base\Html;

interface AutoSubmittingInputInterface
{
    /**
     * Sets auto-submitting option value.
     *
     * If auto-submitting turned on, form will be submitted automatically on input value change.
     *
     * @param bool $value
     * @return $this
     */
    public function setAutoSubmitting($value);

    /**
     * Returns auto-submitting option value.
     *
     * If auto-submitting turned on, form will be submitted automatically on input value change.
     *
     * @return bool
     */
    public function getAutoSubmitting();

    /**
     * Returns true if auto-submitting turned on.
     *
     * If auto-submitting turned on, form will be submitted automatically on input value change.
     * @return bool
     */
    public function isAutoSubmitted();

    /**
     * Enables auto-submitting.
     *
     * @return $this
     */
    public function enableAutoSubmitting();

    /**
     * Disables auto-submitting.
     *
     * @return $this
     */
    public function disableAutoSubmitting();
}
