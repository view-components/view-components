<?php

namespace ViewComponents\ViewComponents\Input;

/**
 * Class InputOption.
 *
 * InputOption class resolves option specified by key
 * from input or returns pre-configured default value.
 *
 */
class InputOption
{

    private $inputValue;
    private $key;
    private $default;

    /**
     * Constructor.
     *
     * @param string $key
     * @param array $inputSource
     * @param mixed $default
     */
    public function __construct(
        $key,
        array $inputSource,
        $default = null
    ) {

        $this->inputValue = array_key_exists($key, $inputSource) ? $inputSource[$key] : null;
        $this->default = $default;
        $this->key = $key;
    }

    /**
     * Returns value (from input or default).
     *
     * @return mixed
     */
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

    /**
     * Returns true if object has value (default or from input).
     *
     * @return bool
     */
    public function hasValue()
    {
        return $this->getValue() !== null;
    }

    private function hasInputValue()
    {
        return $this->inputValue !== null && $this->inputValue !== '';
    }
}
