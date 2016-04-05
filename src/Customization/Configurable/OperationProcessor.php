<?php

namespace ViewComponents\ViewComponents\Customization\Configurable;

use Closure;
use Nayjest\StrCaseConverter\Str;
use ViewComponents\ViewComponents\Base\ComponentInterface;

/**
 * Class OperationProcessor.
 *
 * @internal
 */
class OperationProcessor
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * Constructor.
     *
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Applies operations to target component.
     *
     * @param ComponentInterface $component
     * @param $operations
     */
    public function apply(ComponentInterface $component, $operations)
    {
        if (is_string($operations) || $operations instanceof Closure) {
            $operations = [$operations];
        }
        foreach ($operations as $operation) {
            if (is_string($operation)) {
                list($key, $value) = explode(':', $operation);
                $operation = [$key => $value];
            } elseif ($operation instanceof Closure) {
                $operation = [$operation];
            }
            $this->applyInternal($component, $operation);
        }

    }

    protected function applyInternal(ComponentInterface $component, array $operation)
    {
        foreach ($operation as $key => $value) {
            if ($value instanceof Closure) {
                $func = $value;
                $arguments = [$component, $this->helper];
            } else {
                $methodName = lcfirst(Str::toCamelCase($key));
                if (!method_exists($this->helper, $methodName)) {
                    return;
                }
                $func = [$this->helper, $methodName];
                $arguments = array_merge([$component], is_array($value) ? $value : [$value]);
            }
            call_user_func_array($func, $arguments);
        }
    }
}
