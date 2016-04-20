<?php

namespace ViewComponents\ViewComponents\Input;

/**
 * InputOption represents option specified by key inside input array ($_GET, $_POST, etc.) and its default value.
 */
class InputOption
{
    /** @var mixed */
    private $inputValue;

    /** @var string */
    private $key;

    /** @var mixed */
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
     * Returns value from input or default value if input is not provided.
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
     * Returns input key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Returns true if InputOption has value (default or received from input).
     *
     * @return bool
     */
    public function hasValue()
    {
        return $this->getValue() !== null;
    }

    /**
     * Returns true if InputOption has value received from input (this method does not use default value).
     *
     * @return bool
     */
    private function hasInputValue()
    {
        return $this->inputValue !== null && $this->inputValue !== '';
    }
}
