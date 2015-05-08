<?php
namespace Nayjest\ViewComponents\Styling;

use Nayjest\ViewComponents\BaseComponents\ComponentInterface;
use Nayjest\ViewComponents\BaseComponents\ContainerInterface;

abstract class AbstractStyling
{
    public function apply(ComponentInterface $component)
    {
        $this->applyInternal($component);
        if ($component instanceof ContainerInterface) {
            foreach ($component->components() as $child) {
                $this->apply($child);
            }

        }
    }

    abstract protected function applyInternal(ComponentInterface $component);
}
