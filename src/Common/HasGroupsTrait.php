<?php

namespace Nayjest\ViewComponents\Common;

use Nayjest\ViewComponents\Exceptions\GroupIsNotEmptyException;
use Nayjest\ViewComponents\Exceptions\NonExistingGroupException;

trait HasGroupsTrait
{

    protected $groups = [
        // default group, null is casted to ''
        '' => []
    ];

    /**
     * Returns list of groups
     *
     * @return string[]|array
     */
    public function getGroups()
    {
        return array_keys($this->groups);
    }


    /**
     * @param array|string[] $groups
     * @return $this
     */
    public function setGroups(array $groups)
    {
        // remove non-existing groups
        foreach ($this->groups as $oldGroup) {
            if (!array_key_exists($oldGroup, $groups)
                && $oldGroup !== ''
                && $oldGroup !== null
            ) {
                if (count($this->groups[$oldGroup]) !== 0) {
                    throw new GroupIsNotEmptyException();
                }
                unset($this->groups[$oldGroup]);
            }
        }
        $this->addGroups($groups);
        return $this;
    }

    public function addGroups(array $groups)
    {
        // add new groups
        foreach ($groups as $newGroup) {
            if (!$this->hasGroup($newGroup)) {
                $this->groups[$newGroup] = [];
            }
        }
    }

    /**
     * @param string $groupName
     * @return bool
     */
    public function hasGroup($groupName)
    {
        return array_key_exists($groupName, $this->groups);

    }

    public function getByGroups()
    {
        return $this->groups;
    }

    /**
     * @param string $group
     * @return array
     */
    public function getByGroup($group)
    {
        if (!$this->hasGroup($group)) {
            throw new NonExistingGroupException();
        }
        return $this->groups[$group];
    }

    protected function clearGroups()
    {
        $groupNames = array_keys($this->groups);
        foreach ($groupNames as $groupName) {
            $this->groups[$groupName] = [];
        }
        // push all items to default group
        $this->groups[null] = $this->items;
    }

    protected function removeFromGroups($item)
    {
        foreach ($this->groups as &$group) {
            $key = array_search($item, $group, true);
            if ($key !== false) {
                unset($group[$key]);
                return;
            }
        }
    }

    protected function addToGroup($item, $prepend, $group)
    {
        if (!$this->hasGroup($group)) {
            throw new NonExistingGroupException();
        }
        if ($prepend) {
            array_unshift($this->groups[$group], $item);
        } else {
            $this->groups[$group][] = $item;
        }
    }
}
