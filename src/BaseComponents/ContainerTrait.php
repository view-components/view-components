<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Rendering\ViewInterface;
use Nayjest\ViewComponents\Structure\ParentNodeTrait;

trait ContainerTrait
{
    use ParentNodeTrait;
    use ComponentTrait;

    public function renderComponents($section = null)
    {
        $components = $this
            ->components()
            ->findAllBySection($section);
        $output = '';
        foreach ($components as $component) {
            $output .= $component->render();
        }
        return $output;
    }
}
