<?php
namespace Nayjest\ViewComponents\BaseComponents;

use Nayjest\ViewComponents\Structure\ParentNodeInterface;

interface ContainerInterface extends
    ComponentInterface,
    ParentNodeInterface
{
    /**
     * @param string|null $section
     * @return string
     */
    public function renderComponents($section = null);
}
