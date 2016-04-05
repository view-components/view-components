<?php

namespace ViewComponents\ViewComponents\Component\ManagedList;

use ViewComponents\ViewComponents\Component\Html\ResetButton as HtmlResetButton;
use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Component\Part;

/**
 * Button that resets form inputs (including values submitted previously).
 */
class ResetButton extends Part
{
    const ID = 'reset_button';

    /**
     * ResetButton constructor.
     *
     * @param string $text
     * @param array $attributes
     */
    public function __construct($text = 'Reset', array $attributes = ['style' => 'margin:2px;'])
    {
        $attributes['onclick'] = 'var form = jQuery(this).parents().filter("form");'
            . 'form.find("input:not([type=\'submit\']), select").val("");'
            . 'form.submit(); return false;';
        parent::__construct(new HtmlResetButton($text, $attributes), static::ID, ManagedList::CONTROL_CONTAINER_ID);
    }
}
