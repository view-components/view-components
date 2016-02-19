<?php

namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\Compound\CompoundPartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use RuntimeException;

class CompoundPart extends ViewAggregate implements CompoundPartInterface
{
    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $destinationParentId;

    public function __construct(ViewComponentInterface $view = null, $id = null, $destinationParentId = Compound::ROOT_ID)
    {
        parent::__construct($view);
        $this->id = $id;
        $this->destinationParentId = $destinationParentId;
    }

    /**
     * @param string|null $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string|null $destinationParentId
     * @return CompoundPart
     */
    public function setDestinationParentId($destinationParentId)
    {
        $this->destinationParentId = $destinationParentId;
        return $this;
    }

    /**
     * @param Compound $root
     * @return string|null
     */
    public function getId(Compound $root = null)
    {
        return $this->id;
    }

    /**
     * @param Compound|null $root
     * @return string|null
     */
    public function getDestinationParentId(Compound $root = null)
    {
        return $this->destinationParentId;
    }

    /**
     * @return $this|ViewComponentInterface
     */
    public function getInnerContainer()
    {
        return $this->getView() instanceof ContainerComponentInterface ? $this->getView() : $this;
    }

    public function attachToCompound(Compound $root)
    {
        $parentId = $this->getDestinationParentId();
        if ($parentId === Compound::ROOT_ID) {
            $root->addChild($this);
        } else {
            $components = $root->getComponents();
            /** @var CompoundPartInterface $parent */
            $parent = $components->findByProperty('id', $parentId, true);
            if (!$parent) {
                $id = $this->getId();
                throw new RuntimeException(
                    "Trying to attach compound part '$id' to not existing '$parentId'."
                );
            }
            if ($this->parent() !== $parent->getInnerContainer()) {
                $parent->getInnerContainer()->addChild($this);
            }
        }
        return $this;
    }
}
