<?php

namespace Presentation\Framework\Component;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Rendering\ViewTrait;

/**
 * HideIfNoChildren component hides it's children tree if there are no children on next hierarchy level.
 * This component may be useful to hide containers if they are empty.
 *
 */
class HideIfNoChildren implements ComponentInterface
{
    use ViewTrait;
    use NodeTrait;
    use ComponentTrait {
        ComponentTrait::render as private renderInternal;
    }

    /**
     * @param array|ComponentInterface[] $components
     */
    public function __construct($components = [])
    {
        $this->children()->set($components);
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->isRenderingRequired() ? $this->renderInternal() : '';
    }

    /**
     * Returns true if component will be rendered.
     *
     * @return bool
     */
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
