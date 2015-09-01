<?php

namespace Presentation\Framework\Input;

class InputOption
{

    private $inputValue;
    private $key;
    private $default;

    /**
     * Constructor.
     *
     * @param string $key
     * @param array $input
     * @param mixed $default
     */
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
     * Returns default value or NULL if no default value was specified.
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->default;
    }

    /**
     * Returns value from input or NULL if value not exists.
     *
     * @return mixed
     */
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
