<?php

namespace ViewComponents\ViewComponents\Component\Layout;

use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\Compound\PartTrait;
use ViewComponents\ViewComponents\Component\Container;
use ViewComponents\ViewComponents\Component\Layout;

/**
 * Layout section.
 *
 * This component should not be used separately from Layout class.
 *
 * This component should not be instantiated manually,
 * Layout class can create required sections itself.
 */
class Section extends Container implements PartInterface
{
    use PartTrait;

    /**
     * Section constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct();
        $this->setDestinationParentId('template');
        $this->setId('section-' . $name);
    }

    /**
     * Includes javascript resource. Prevents including same resource twice.
     *
     * @param string $name resource Url or alias name
     * @return $this
     */
    public function js($name)
    {
        $this->getLayout()->js($name)->attachTo($this);
        return $this;
    }

    /**
     * Includes CSS resource. Prevents including same resource twice.
     *
     * @param string $name resource Url or alias name
     * @param array $attributes
     * @return $this
     */
    public function css($name, $attributes = [])
    {
        $this->getLayout()->css($name, $attributes)->attachTo($this);
        return $this;
    }

    /**
     * @return Layout|null
     */
    protected function getLayout()
    {
        return $this->root;
    }
}
