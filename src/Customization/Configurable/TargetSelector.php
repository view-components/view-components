<?php

namespace ViewComponents\ViewComponents\Customization\Configurable;

use Nayjest\StrCaseConverter\Str;
use RuntimeException;
use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\Html\TagInterface;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateInterface;

/**
 * Class TargetSelector.
 * @internal
 */
class TargetSelector
{
    /**
     * TargetSelector constructor.
     */
    public function __construct()
    {
    }

    public function check($selector, ComponentInterface $component)
    {
        $selector = str_replace('#', '&property:id,', $selector);
        return $this->checkOr($selector, $component);
    }

    public function checkAnd($selector, ComponentInterface $component)
    {
        $parts = explode('&', $selector);
        foreach ($parts as $selectorPart) {
            if ($selectorPart === '') {
                continue;
            }
            if (strpos($selectorPart, '[') !== false) {
                list($head, $tail) = explode('[', $selectorPart);
                $tail = 'property:' . str_replace(']', '', $tail);
                if (!$this->checkAnd("$head&$tail", $component)) {
                    return false;
                }
            }
            if (!$this->checkOne($selectorPart, $component)) {
                return false;
            }
        }
        return true;
    }

    public function checkOr($selector, ComponentInterface $component)
    {
        $parts = explode('|', $selector);
        foreach ($parts as $selectorPart) {
            if ($this->checkAnd($selectorPart, $component)) {
                return true;
            }
        }
        return false;
    }

    public function checkOne($selector, ComponentInterface $component)
    {
        $data = explode(':', $selector);
        if (count($data) === 2) {
            $conditionType = $data[0];
            $conditionArguments = explode(',', $data[1]);
        } elseif (count($data) === 1) {
            if ($this->isConditionMethod($selector)) {
                $conditionType = $selector;
                $conditionArguments = [];
            } else {
                $conditionType = 'class';
                $conditionArguments = $data;
            }
        } else {
            throw new RuntimeException('Error parsing target selector.');
        }

        if (!$this->isConditionMethod($conditionType)) {
            throw new RuntimeException('Unknown target selector condition type.');
        }
        $callable = [$this, $this->getConditionMethod($conditionType)];
        $result = call_user_func_array($callable, array_merge([$component], $conditionArguments));
        return $result;
    }

    public function checkClassCondition(ComponentInterface $component, $className)
    {
        return $component instanceof $className;
    }

    public function checkCompoundPartCondition(ComponentInterface $component, $id = null)
    {
        return $component instanceof PartInterface && ($id ? ($component->getId() === $id) : true);
    }

    public function checkTagCondition(ComponentInterface $component, $tagName = null)
    {
        return $component instanceof TagInterface && ($tagName ? ($component->getTagName() === $tagName) : true);
    }

    public function checkRootCondition(ComponentInterface $component)
    {
        return property_exists($component, 'isRootOfCustomizations');
    }

    public function checkTemplateCondition(ComponentInterface $component, $templateName = null)
    {
        return $component instanceof TemplateView
        && ($templateName ? ($component->getTemplateName() === $templateName) : true);
    }

    public function checkDataItemCondition(ComponentInterface $component, $name, $value)
    {
        return $component instanceof ArrayDataAggregateInterface && $component->getDataItem($name) == $value;
    }

    public function checkPropertyCondition(ComponentInterface $component, $property, $value)
    {
        return
            (\mp\getValue($component, $property) == $value)
            || ($component instanceof TagInterface && $component->getAttribute($property) == $value);
    }

    public function checkNoPropertyCondition(ComponentInterface $component, $property)
    {
        return
            \mp\getValue($component, $property) == false
             && (!$component instanceof TagInterface || $component->getAttribute($property) == false);
    }

    protected function getConditionMethod($key)
    {
        return 'check' . Str::toCamelCase($key) . 'Condition';
    }

    protected function isConditionMethod($key)
    {
        return method_exists($this, $this->getConditionMethod($key));
    }
}
