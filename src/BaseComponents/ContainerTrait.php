<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Structure\ParentNodeTrait;

trait ContainerTrait
{
    use ParentNodeTrait;
    use ComponentTrait;

    public function renderComponents($group = null)
    {
        $components = $this
            ->components()
            ->getByGroup($group);
        $output = '';
        /** @var ComponentInterface $component */
        foreach ($components as $component) {
            $output .= $component->render();
        }
        return $output;
    }
}
