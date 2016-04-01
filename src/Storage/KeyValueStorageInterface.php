<?php

namespace ViewComponents\ViewComponents\Storage;

/**
 * Interface of key-value storage.
 */
interface KeyValueStorageInterface
{
    public function has($key);
    public function delete($key);
    public function get($key);
    public function set($key, $value);
}
