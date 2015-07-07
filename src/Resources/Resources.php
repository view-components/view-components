<?php
namespace Presentation\Framework\Resources;

use Presentation\Framework\Components\Dummy;
use Presentation\Framework\Components\Html\Script;
use Presentation\Framework\Components\Html\Tag;

class Resources
{
    protected $jsRegistry;
    protected $cssRegistry;
    protected $included;
    protected $dummyComponent;

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

    protected function getDummyComponent()
    {
        if ($this->dummyComponent === null) {
            $this->dummyComponent = new Dummy();
        }
        return $this->dummyComponent;
    }

    /**
     * @param string $name script URL or alias
     * @return Dummy|Tag
     */
    public function js($name)
    {
        $src = $this->jsRegistry->get($name, $name);
        if (!$this->included->isIncluded($src)) {
            $this->included->markAsIncluded($src);
            $type = 'text/javascript';
            return new Script(compact('src', 'type'));
        } else {
            return $this->getDummyComponent();
        }
    }

    /**
     * @param string $name CSS URL or alias
     * @param array $attributes
     * @return Dummy|Tag
     */
    public function css($name, array $attributes = [])
    {
        $href = $this->cssRegistry->get($name, $name);
        if (!$this->included->isIncluded($href)) {
            $this->included->markAsIncluded($href);
            return new Tag('link', array_merge([
                'type' => 'text/css',
                'rel' => 'stylesheet',
                'href' => $href,
                'media' => 'all'
            ], $attributes));
        } else {
            return $this->getDummyComponent();
        }
    }
}
