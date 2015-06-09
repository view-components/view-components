<?php

namespace Nayjest\ViewComponents\Structure;

use Nayjest\Manipulator\Manipulator;
use Nayjest\ViewComponents\Data\DataAcceptorInterface;
use Traversable;

trait TreeNodesCollectionTrait
{
    abstract public function toArray();

    /**
     * @param Traversable|array $data
     * @return $this
     */
    public function fillItemsWith($data)
    {
        foreach($this->toArray() as $item) {
            if ($item instanceof DataAcceptorInterface) {
                $item->setData($data);
            } else {
                $writable = Manipulator::getWritable($item);
                $fields = Manipulator::getValues($data, $writable);
                Manipulator::assign($item, $fields);
            }
        }
        return $this;
    }

    /**
     * @todo unused now
     * @return mixed
     */
    public function plain()
    {
        $children = $this->toArray();
        $res = $children;
        foreach($children as $item) {
            if ($item instanceof ParentNodeTrait) {
                $res += $item->components()->plain();
            }
        }
        return $res;
    }
}
