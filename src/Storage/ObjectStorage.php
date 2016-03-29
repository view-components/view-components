<?php

namespace ViewComponents\ViewComponents\Storage;

class ObjectStorage implements KeyValueStorageInterface
{
    /**
     * @var KeyValueStorageInterface
     */
    private $storage;

    public function __construct(KeyValueStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function get($key)
    {
        $item = $this->storage->get($key);
        return unserialize($item);
    }

    public function set($key, $value)
    {
        $this->storage->set($key, serialize($value));
        return $this;
    }

    public function has($key)
    {
        return $this->storage->has($key);
    }

    public function delete($key)
    {
        $this->storage->delete($key);
        return $this;
    }
}
