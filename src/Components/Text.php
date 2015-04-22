<?php
namespace Nayjest\ViewComponents\Components;

use Closure;
use Nayjest\ViewComponents\BaseComponents\AbstractComponent;

class Text extends AbstractComponent
{
    protected $value;

    /**
     * @param string|null $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function render()
    {
        return $this->value instanceof Closure ?
            call_user_func($this->value, $this)
            : (string)$this->value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
