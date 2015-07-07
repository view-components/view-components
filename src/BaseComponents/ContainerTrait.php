<?php
namespace Presentation\Framework\BaseComponents;

use Presentation\Framework\Rendering\ViewInterface;
use Presentation\Framework\Structure\ParentNodeTrait;

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
            if ($component instanceof ViewInterface) {
                $output .= $component->render();
            }
        }
        return $output;
    }

    public function renderAllComponents()
    {
        $output = '';
        $groups = $this->components()->getGroups();
        foreach($groups as $group)
        {
            $output .= $this->renderComponents($group);
        }
        return $output;
    }
}
