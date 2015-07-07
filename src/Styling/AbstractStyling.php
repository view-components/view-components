<?php
namespace Presentation\Framework\Styling;

use Presentation\Framework\BaseComponents\ComponentInterface;
use Presentation\Framework\BaseComponents\ContainerInterface;

abstract class AbstractStyling
{
    public function apply(ComponentInterface $component)
    {
        $this->applyInternal($component);
        if ($component instanceof ContainerInterface) {
            $this->applyToChildren($component);
        }
    }

    protected function applyToChildren(ContainerInterface $component)
    {
        foreach ($component->components() as $child) {
            $this->applyInternal($child);
            if ($child instanceof ContainerInterface) {
                $this->applyToChildren($child);
            }
        }
    }

    abstract protected function applyInternal(ComponentInterface $component);
}
