<?php

namespace Presentation\Framework\Component;
use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Rendering\ViewTrait;

/**
 * CompoundComponent contains tree configuration and plain components list.
 * The class builds components tree and provides readonly access to it via children() method.
 *
 */
class HideIfNoChildren implements ComponentInterface
{
    use ViewTrait;
    use NodeTrait;
    use ComponentTrait {
        ComponentTrait::render as private renderInternal;
    }

    public function __construct($components = [])
    {
        $this->children()->set($components);
    }

    public function render()
    {
        return $this->isRenderingRequired() ? $this->renderInternal() : '';
    }

    public function isRenderingRequired()
    {
        /** @var ComponentInterface $child */
        foreach ($this->children() as $child) {
            if (!$child->children()->isEmpty()) {
                return true;
            }
        }
        return false;
    }
}
