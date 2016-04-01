<?php

namespace ViewComponents\ViewComponents\Storage;

/**
 * Key-value storage for serializable PHP objects.
 * ObjectStorage is a wrapper for key-value storages that performs serialization and deserialization.
 */
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
