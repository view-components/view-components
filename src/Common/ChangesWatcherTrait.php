<?php
namespace ViewComponents\ViewComponents\Common;

trait ChangesWatcherTrait
{
    use StateHashTrait;

    private static $lastStates = [];

    public static function resetChangesWatching()
    {
        self::$lastStates = [];
    }

    public function isChanged()
    {
        $key = spl_object_hash($this);
        $currentState = $this->getStateHash();
        $result = !array_key_exists($key, self::$lastStates)
            || self::$lastStates[$key] !== $currentState;
        self::$lastStates[$key] = $currentState;
        return $result;
    }
}
