<?php

namespace Nayjest\ViewComponents\Structure;

use LogicException;
use Nayjest\ViewComponents\Rendering\ChildViewInterface;
// use Symfony\Component\PropertyAccess\PropertyAccess;

class Collection
{
    /** @var ChildInterface[] */
    protected $items = [];

    protected $owner;

    //protected static $propertyAccessor;

    /**
     * Constructor.
     *
     * @param ParentInterface $owner
     */
    public function __construct(ParentInterface $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Adds component to collection.
     *
     * If component is already in collection, it will not be added twice.
     *
     * @param ChildInterface $component
     * @param bool $prepend Pass true to add component to the beginning of an array.
     * @return $this
     */
    public function add(ChildInterface $component, $prepend = false)
    {
        $old = $component->getParent();
        if ($old !== $this->owner) {
            if ($old !== null) {
                $component
                    ->getParent()
                    ->components()
                    ->remove($component);
            }
            $component->internalSetParent($this->owner);
            if ($prepend) {
                array_unshift($this->items, $component);
            } else {
                $this->items[] = $component;
            }
        }
        return $this;
    }

    public function remove(ChildInterface $component)
    {
        if ($component->getParent() === $this->owner) {
            $component->internalUnsetParent();
            $key = array_search($component, $this->items, true);
            if ($key === false) {
                throw new LogicException(
                    'Bidirectional association is broken.'
                );
            }
            unset($this->items[$key]);
        }
        return $this;
    }

    public function has(ChildInterface $component)
    {
        return in_array($component, $this->items, true);
    }

    /**
     * @param ChildInterface[] $components
     */
    public function set(array $components)
    {
        $this->clean();
        foreach ($components as $component) {
            $this->add($component);
        }
    }

    public function clean()
    {
        foreach ($this->items as $item) {
            $item->internalUnsetParent();
        }
        $this->items = [];
    }

    public function toArray()
    {
        return $this->items;
    }

    public function isEmpty()
    {
        return count($this->items) === 0;
    }

    public function getSize()
    {
        return count($this->items);
    }

//    /**
//     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
//     */
//    protected static function getPropertyAccessor()
//    {
//        if (self::$propertyAccessor === null) {
//            self::$propertyAccessor = PropertyAccess::createPropertyAccessor();
//        }
//        return self::$propertyAccessor;
//    }

//    /**
//     * @param string $attribute
//     * @param $value
//     * @return ChildInterface[]
//     */
//    public function findAllByAttribute($attribute, $value)
//    {
//        $accessor = self::getPropertyAccessor();
//        $results = [];
//        foreach($this->items as $item) {
//            if (
//                $accessor->isReadable($item, $attribute)
//                and $accessor->getValue($item, $attribute) === $value
//            ) {
//                $results[] = $item;
//            }
//        }
//        return $results;
//    }

    /**
     * @param string $section_name
     * @return ChildViewInterface
     */
    public function findAllBySection($section_name)
    {
        $results = [];
        foreach ($this->items as $item) {
            if (
                $item instanceof ChildViewInterface
                && $item->getRenderSection() === $section_name
            ) {
                $results[] = $item;
            }
        }
        return $results;
    }
}
