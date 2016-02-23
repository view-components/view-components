<?php

namespace ViewComponents\ViewComponents\Base\Compound;


use RuntimeException;
use ViewComponents\ViewComponents\Component\Compound;

trait PartTrait
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $destinationParentId;

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
     * @return $this
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

    public function attachToCompound(Compound $root)
    {
        /** @var PartInterface $this */
        $parentId = $this->getDestinationParentId();
        if ($parentId === Compound::ROOT_ID) {
            if ($this->parent() !== $root) {
                $root->addChild($this);
                return true;
            }
        } else {
            $parts = $root->getComponents();
            /** @var ContainerPartInterface $parent */
            $parent = $parts->findByProperty('id', $parentId, true);
            if (!$parent) {
                $id = $this->getId();
                throw new RuntimeException(
                    "Trying to attach compound part '$id' to not existing '$parentId'."
                );
            }
            if (!$parent instanceof ContainerPartInterface) {
                $id = $this->getId();
                throw new RuntimeException(
                    "Trying to attach compound part '$id' to invalid container '$parentId'."
                );
            }
            if ($this->parent() !== $parent->getContainer()) {
                $parent->getContainer()->addChild($this);
                return true;
            }
        }
        return false;
    }
}
