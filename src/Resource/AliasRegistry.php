<?php
namespace ViewComponents\ViewComponents\Resource;

/**
 * Class AliasRegistry.
 *
 * The class implements registry of aliases.
 *
 * @package ViewComponents\ViewComponents\Resources
 */
class AliasRegistry
{
    /**
     * @var string[]
     */
    protected $aliases;

    /**
     * Constructor.
     *
     * @param array $aliases where keys are aliases and values are aliased values (names, URIs).
     */
    public function __construct(array $aliases = [])
    {
        $this->aliases = $aliases;
    }

    /**
     * Creates/updates alias.
     *
     * @param string $name
     * @param string $url
     * @param bool $overwrite (false by default)
     * @return bool true if alias was created/updated.
     */
    public function set($name, $url, $overwrite = false)
    {
        if (!$overwrite && array_key_exists($name, $this->aliases)) {
            return false;
        }
        $this->aliases[$name] = $url;
        return true;
    }

    /**
     * Returns aliased value or default value if requested alias does not exists.
     *
     * @param string $name
     * @param string|null $default
     * @return string|null
     */
    public function get($name, $default = null)
    {
        if (array_key_exists($name, $this->aliases)) {
            return $this->aliases[$name];
        } else {
            return $default;
        }
    }

    /**
     * Returns true if alias exists.
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->aliases);
    }
}
