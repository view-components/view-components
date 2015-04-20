<?php
namespace Nayjest\ViewComponents\Components;

use Closure;
use Nayjest\ViewComponents\Components\Base\Component;

class Text extends Component
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function render()
    {
        return $this->value instanceof Closure ?
            call_user_func($this->value, $this)
            : $this->value;
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