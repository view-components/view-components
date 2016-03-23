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

    /** @var  Compound|null */
    protected $root;

    /**
     * @param string|null $id
     * @return $this
     */
    public function setId($id)
    {
        if ($this->root) {
            $this->root->requireTreeUpdate();
        }
        $this->id = $id;
        return $this;
    }

    /**
     * @param string|null $destinationParentId
     * @return $this
     */
    public function setDestinationParentId($destinationParentId)
    {
        if ($this->root) {
            $this->root->requireTreeUpdate();
        }
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

    public function attachToCompound(Compound $root, $prepend = false)
    {
        $this->root = $root;
        if (!$root->getComponents()->contains($this)) {
            $root->getComponents()->add($this);
        }
        /** @var PartInterface $this */
        $parentId = $this->getDestinationParentId();
        if ($parentId === Compound::ROOT_ID) {
            if ($this->parent() !== $root) {
                $root->children()->add($this, $prepend);
                return;
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
                $parent->getContainer()->children()->add($this, $prepend);
                return;
            }
        }
        return;
    }

    /**
     * @return null|Compound
     */
    public function getRoot()
    {
        return $this->root;
    }

    public function isAttached()
    {
        return $this->root !== null;
    }
}
