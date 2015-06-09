<?php

namespace Nayjest\ViewComponents\Collection;

/**
 * Class ReadonlyGroupedCollection
 *
 * @property GroupedCollection $collection
 */
class ReadonlyGroupedCollection extends ReadonlyCollection
{
    public function getGroups()
    {
        return $this->collection->getGroups();
    }

    /**
     * @param string $groupName
     * @return bool
     */
    public function hasGroup($groupName)
    {
        return $this->collection->hasGroup($groupName);

    }

    public function getByGroups()
    {
        return $this->collection->getByGroups();
    }

    public function getByGroup($group)
    {
        return $this->collection->getByGroup($group);
    }
}