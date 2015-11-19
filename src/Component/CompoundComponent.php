<?php

namespace Presentation\Framework\Component;

use Nayjest\Tree\NodeTrait;
use Nayjest\Tree\Tree;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Common\CompoundPartCollection;
use Presentation\Framework\Common\TreeAggregate;
use Presentation\Framework\Rendering\ViewTrait;
use Traversable;

/**
 * CompoundComponent contains tree configuration and plain components list.
 * The class builds components tree and provides readonly access to it via children() method.
 *
 */
class CompoundComponent implements ComponentInterface
{
    use ViewTrait;
    use NodeTrait {
        NodeTrait::children as private childrenInternal;
        NodeTrait::initializeCollection as initializeCollectionInternal;
    }
    use ComponentTrait;
    use TreeAggregate;

    /**
     * Constructor.
     *
     * @param array $hierarchy
     * @param ComponentInterface[]|Traversable $components
     */
    public function __construct(array $hierarchy = [], $components = [])
    {
        $this->tree = new Tree($this, $hierarchy, $components);
    }

    /**
     * Returns child components.
     *
     * This method is overriden to provide hierarchy update if components registry was changed.
     *
     * @return CompoundPartCollection
     */
    public function children()
    {
        $this->tree->build();
        return $this->childrenInternal();
    }

    /**
     * @param array $items
     */
    protected function initializeCollection(array $items)
    {
        $this->collection = new CompoundPartCollection(
            $this,
            $items
        );
    }

}
