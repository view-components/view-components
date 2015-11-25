<?php

namespace Presentation\Framework\Base;

use Presentation\Framework\Component\CompoundComponent;

interface CompoundPartInterface extends ComponentInterface
{
    /**
     * @param CompoundComponent $root
     * @return string|null
     */
    public function resolveParentName(CompoundComponent $root);

    /**
     * @return CompoundComponent|null
     */
    public function getRoot();

    public function setRootInternal(CompoundComponent $root);
}