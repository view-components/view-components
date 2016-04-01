<?php

namespace ViewComponents\ViewComponents\Storage;

use InvalidArgumentException;

/**
 * File-based key-value storage.
 */
class FileStorage implements KeyValueStorageInterface
{
    /**
     * @var
     */
    private $storagePath;

    /**
     * Constructor.
     *
     * @param string $storagePath path to folder storing data.
     */
    public function __construct($storagePath)
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @return string
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /**
     * @param string $storagePath
     * @return $this
     */
    public function setStoragePath($storagePath)
    {
        $this->storagePath = $storagePath;
        return $this;
    }

    public function has($key)
    {
        return file_exists($this->getFileName($key));
    }

    public function delete($key)
    {
        if (!$this->has($key)) {
            throw new InvalidArgumentException(
                'Trying to delete not existing item from storage'
            );
        }
        unlink($this->getFileName($key));
        return $this;
    }

    public function get($key)
    {
        if (!$this->has($key)) {
            throw new InvalidArgumentException(
                'Trying to receive not existing item from storage'
            );
        }
        return file_get_contents($this->getFileName($key));
    }

    public function set($key, $value)
    {
        if ($this->has($key)) {
            $this->delete($key);
        }
        $this->prepareStorage();
        file_put_contents($this->getFileName($key), $value);
        return $this;
    }

    protected function getFileName($key)
    {
        return $this->getStoragePath() . '/' . $key;
    }

    protected function prepareStorage()
    {
        if (!file_exists($this->getStoragePath())) {
            mkdir($this->getStoragePath(), 0777, true);
        }
    }
}
