<?php
namespace ViewComponents\ViewComponents\Resource;

use InvalidArgumentException;
use ViewComponents\ViewComponents\Component\DataView;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\Html\TagWithText;

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
    ) {
        $this->jsRegistry = $js;
        $this->cssRegistry = $css;
        $this->included = $included;
    }

    /**
     * Returns component that renders html script tag for including specified javascript resource
     * or component that renders empty string if resource was already included.
     *
     * @param string $aliasOrUrl script URL or alias
     * @return Tag|DataView
     */
    public function js($aliasOrUrl)
    {
        $url = $this->getJsUrl($aliasOrUrl);
        if (!$this->included->isIncluded($url)) {
            $this->included->markAsIncluded($url);
            $type = 'text/javascript';
            return new Tag('script', ['src' => $url, 'type' => $type]);
        } else {
            return new DataView();
        }
    }

    /**
     * Returns component that includes CSS resource to html page or
     * component that renders empty string if resource was already included.
     *
     * @param string $aliasOrUrl CSS URL or alias
     * @param array $attributes
     * @return Tag|DataView
     */
    public function css($aliasOrUrl, array $attributes = [])
    {
        $url = $this->getCssUrl($aliasOrUrl);
        if (!$this->included->isIncluded($url)) {
            $this->included->markAsIncluded($url);
            return new Tag('link', array_merge([
                'type' => 'text/css',
                'rel' => 'stylesheet',
                'href' => $url,
                'media' => 'all'
            ], $attributes));
        } else {
            return new DataView();
        }
    }

    /**
     * Ignores target css file (adds it to registry of included resources).
     *
     * @param string|string[] $aliasOrUrl
     * @return $this
     */
    public function ignoreCss($aliasOrUrl)
    {
        if (is_array($aliasOrUrl)) {
            foreach ($aliasOrUrl as $item) {
                $this->ignoreCss($item);
            }
            return $this;
        }
        $url = $this->getCssUrl($aliasOrUrl);
        if (!$this->included->isIncluded($url)) {
            $this->included->markAsIncluded($url);
        }
        return $this;
    }

    /**
     * Ignores target js file (adds it to registry of included resources).
     *
     * @param string|string[] $aliasOrUrl
     * @return $this
     */
    public function ignoreJs($aliasOrUrl)
    {
        if (is_array($aliasOrUrl)) {
            foreach ($aliasOrUrl as $item) {
                $this->ignoreJs($item);
            }
            return $this;
        }
        $url = $this->getJsUrl($aliasOrUrl);
        if (!$this->included->isIncluded($url)) {
            $this->included->markAsIncluded($url);
        }
        return $this;
    }

    /**
     * Returns registry of js aliases.
     *
     * @return AliasRegistry
     */
    public function jsAliases()
    {
        return $this->jsRegistry;
    }

    /**
     * Returns registry of css aliases.
     *
     * @return AliasRegistry
     */
    public function cssAliases()
    {
        return $this->cssRegistry;
    }

    /**
     * Returns registry of included resources.
     *
     * @return IncludedResourcesRegistry
     */
    public function includedResources()
    {
        return $this->included;
    }

    /**
     * Returns component that renders 'script' tag with js code.
     *
     * @param string $jsCode
     * @param string|null $uniqueId specify unique id for inline code to avoid embedding it twice
     * @return DataView|TagWithText
     */
    public function inlineJs($jsCode, $uniqueId = null)
    {
        if ($uniqueId !== null) {
            if ($this->included->isIncluded($uniqueId)) {
                return new DataView();
            } else {
                $this->included->markAsIncluded($uniqueId);
            }
        }
        return new TagWithText('script', $jsCode);
    }

    /**
     * Returns component that renders 'style' tag with css code.
     *
     * @param string $cssCode
     * @param string|null $uniqueId specify unique id for inline code to avoid embedding it twice
     * @return DataView|TagWithText
     */
    public function inlineCss($cssCode, $uniqueId = null)
    {
        if ($uniqueId !== null) {
            if ($this->included->isIncluded($uniqueId)) {
                return new DataView();
            } else {
                $this->included->markAsIncluded($uniqueId);
            }
        }
        return new TagWithText('style', $cssCode);
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
        return strpos($name, '.css') !== false || strpos($name, '//') !== false;
    }

    /**
     * @param string $aliasOrUrl
     * @return null|string
     */
    protected function getJsUrl($aliasOrUrl)
    {
        if ($this->jsRegistry->has($aliasOrUrl)) {
            $url = $this->jsRegistry->get($aliasOrUrl);
        } else {
            if (static::isJsUrl($aliasOrUrl)) {
                $url = $aliasOrUrl;
            } else {
                throw new InvalidArgumentException('Unknown JavaScript alias or invalid URL: ' . $aliasOrUrl);
            }
        }
        return $url;
    }

    /**
     * @param string $aliasOrUrl
     * @return null|string
     */
    protected function getCssUrl($aliasOrUrl)
    {
        if ($this->cssRegistry->has($aliasOrUrl)) {
            $url = $this->cssRegistry->get($aliasOrUrl);
        } else {
            if (static::isCssUrl($aliasOrUrl)) {
                $url = $aliasOrUrl;
            } else {
                throw new InvalidArgumentException('Unknown CSS alias or invalid URL: ' . $aliasOrUrl);
            }
        }
        return $url;
    }
}
