<?php

namespace Nayjest\ViewComponents\Common;

class InputValueReader
{

    private $inputValue;
    private $key;

    public function __construct(
        $key,
        array $input,
        $default = null
    )
    {

        $this->inputValue = array_key_exists($key, $input) ? $input[$key] : null;
        $this->default = $default;
        $this->key = $key;
    }

    public function getValue()
    {
        return $this->hasInputValue()
            ? $this->inputValue
            : $this->default;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    public function hasValue()
    {
        return $this->getValue() !== null;
    }

    private function hasInputValue()
    {
        return $this->inputValue !== null && $this->inputValue !== '';
    }
}
