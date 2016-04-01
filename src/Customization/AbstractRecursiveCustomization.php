<?php
namespace ViewComponents\ViewComponents\Customization;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;

abstract class AbstractRecursiveCustomization implements CustomizationInterface
{
    abstract protected function applyInternal(ComponentInterface $component);

    /**
     * Applies customizations to target component and its children.
     *
     * @param ComponentInterface $component
     */
    public function apply(ComponentInterface $component)
    {
        $this->applyRecursive($component);
    }

    protected function applyRecursive(ComponentInterface $component)
    {
        $this->applyInternal($component);
        if (!$component instanceof ContainerComponentInterface) {
            return;
        }
        foreach ($component->children() as $child) {
            if ($child instanceof ComponentInterface) {
                $this->applyRecursive($child);
            }
        }
    }
}
