<?php
namespace Presentation\Framework\Component;

use Closure;
use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Rendering\ViewTrait;

class Text implements ComponentInterface
{
    use NodeTrait;
    use ViewTrait;
    use ComponentTrait;

    protected $value;

    /**
     * @param string|null|Closure $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function render()
    {
        $text = $this->value instanceof Closure ?
            call_user_func($this->value, $this)
            : (string)$this->value;
        return $text . $this->renderChildren();
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
