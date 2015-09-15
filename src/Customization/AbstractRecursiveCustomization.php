<?php
namespace Presentation\Framework\Customization;

use Presentation\Framework\Base\ComponentInterface;

abstract class AbstractRecursiveCustomization implements CustomizationInterface
{
    abstract protected function applyInternal(ComponentInterface $component);

    public function apply(ComponentInterface $component)
    {
        $this->applyRecursive($component);
    }

    protected function applyRecursive(ComponentInterface $component)
    {
        $this->applyInternal($component);
        foreach ($component->children() as $child) {
            if ($child instanceof ComponentInterface) {
                $this->applyRecursive($child);
            }
        }
    }
}
