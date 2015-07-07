<?php
namespace Presentation\Framework\BaseComponents;

use Presentation\Framework\Structure\ParentNodeInterface;

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
