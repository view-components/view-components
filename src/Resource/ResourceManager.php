<?php
namespace Presentation\Framework\Resource;

use InvalidArgumentException;
use Presentation\Framework\Component\Dummy;
use Presentation\Framework\Component\Html\Script;
use Presentation\Framework\Component\Html\Tag;

class ResourceManager
{
    protected $jsRegistry;
    protected $cssRegistry;
    protected $included;
    protected $dummyComponent;

    /**
     * Constructor.
     *
     * @param AliasRegistry $js
     * @param AliasRegistry $css
     * @param IncludedResourcesRegistry $included
     */
    public function __construct(
        AliasRegistry $js,
        AliasRegistry $css,
        IncludedResourcesRegistry $included
    )
    {
        $this->jsRegistry = $js;
        $this->cssRegistry = $css;
        $this->included = $included;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected static function isJsUrl($name)
    {
        return strpos($name, '.js') !== false || strpos($name, '//') !== false;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected static function isCssUrl($name)
    {
        return strpos($name, '.css') !== false  || strpos($name, '//') !== false;
    }

    /**
     * @param string $name script URL or alias
     * @return Dummy|Tag
     */
    public function js($name)
    {

        if ($this->jsRegistry->has($name)) {
            $url = $this->jsRegistry->get($name);
        } else {
            if (static::isJsUrl($name)) {
                $url = $name;
            } else {
                throw new InvalidArgumentException('Unknown JavaScript alias or invalid URL');
            }
        }
        if (!$this->included->isIncluded($url)) {
            $this->included->markAsIncluded($url);
            $type = 'text/javascript';
            return new Script(['src' => $url, 'type' => $type]);
        } else {
            return Dummy::getInstance();
        }
    }

    /**
     * @param string $name CSS URL or alias
     * @param array $attributes
     * @return Dummy|Tag
     */
    public function css($name, array $attributes = [])
    {

        if ($this->cssRegistry->has($name)) {
            $url = $this->cssRegistry->get($name);
        } else {
            if (static::isCssUrl($name)) {
                $url = $name;
            } else {
                throw new InvalidArgumentException('Unknown CSS alias or invalid URL');
            }
        }
        if (!$this->included->isIncluded($url)) {
            $this->included->markAsIncluded($url);
            return new Tag('link', array_merge([
                'type' => 'text/css',
                'rel' => 'stylesheet',
                'href' => $url,
                'media' => 'all'
            ], $attributes));
        } else {
            return Dummy::getInstance();
        }
    }
}
