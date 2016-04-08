<?php

namespace ViewComponents\ViewComponents\Component\Html;

class ResetButton extends TagWithText
{
    public function __construct($text = 'Reset', array $attributes = [])
    {
        $attributes['type'] = 'reset';
        parent::__construct('button', $text, $attributes);
    }
}
