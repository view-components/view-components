<?php
namespace Nayjest\ViewComponents\Common;

class InputValueReader
{
    use InitializedOnceTrait;

    protected $defaultValue;

    protected $inputValue;

    protected $inputKey;

    public function __construct($inputKey, $defaultValue)
    {
        $this->inputKey = $inputKey;
        $this->defaultValue = $defaultValue;
    }

    public function initialize($input)
    {
        $this->setInitialized();
        $this->inputValue = array_key_exists(
            $this->getInputKey(),
            $input
        ) ? $input[$this->getInputKey()] : null;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDefaultValue($value)
    {
        $this->defaultValue = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getInputKey()
    {
        return $this->inputKey;
    }

    /**
     * @param string $inputKey
     * @return $this
     */
    public function setInputKey($inputKey)
    {
        $this->checkNotInitialized();
        $this->inputKey = $inputKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInputValue()
    {
        $this->checkInitialized();
        return $this->inputValue;
    }

    public function getValue()
    {
        return $this->hasInputValue()
            ? $this->getInputValue()
            : $this->getDefaultValue();
    }

    public function hasInputValue()
    {
        return !$this->isValueEmpty($this->getInputValue());
    }

    public function hasDefaultValue()
    {
        return !$this->isValueEmpty($this->getDefaultValue());
    }

    public function hasValue()
    {
        return $this->hasInputValue() || $this->hasDefaultValue();
    }

    /**
     * note: False and 0 considered not empty
     *
     * @param $value
     * @return bool
     */
    protected function isValueEmpty($value)
    {
        return $value === null or $value === '';
    }

}