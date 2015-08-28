<?php
namespace Presentation\Framework\Styling;

use Presentation\Framework\Base\ComponentInterface;

abstract class AbstractStyling implements StylingInterface
{
    public function apply(ComponentInterface $component)
    {
        $this->applyInternal($component);
        if ($component instanceof ComponentInterface) {
            $this->applyToChildren($component);
        }
    }

    protected function applyToChildren(ComponentInterface $component)
    {
        foreach ($component->children() as $child) {
            $this->applyInternal($child);
            if ($child instanceof ComponentInterface) {
                $this->applyToChildren($child);
            }
        }
    }

    abstract protected function applyInternal(ComponentInterface $component);
}
