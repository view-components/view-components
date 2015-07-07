<?php

namespace Presentation\Framework\Common;

class InputOption
{

    private $inputValue;
    private $key;
    private $default;

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

    public function getDefaultValue()
    {
        return $this->default;
    }

    public function getInputValue()
    {
        return $this->inputValue;
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
