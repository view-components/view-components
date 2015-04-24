<?php
namespace Nayjest\ViewComponents\Resources;

class AliasRegistry
{
    protected $aliases;

    public function __construct(array $aliases = [])
    {
        $this->aliases = $aliases;
    }

    public function set($name, $url, $overwrite = false)
    {
        if (!$overwrite && array_key_exists($name, $this->aliases)) {
            return false;
        }
        $this->aliases[$name] = $url;
        return true;
    }

    public function get($name, $default = null)
    {
        if (array_key_exists($name, $this->aliases)) {
            return $this->aliases[$name];
        } else {
            return $default;
        }
    }
}
