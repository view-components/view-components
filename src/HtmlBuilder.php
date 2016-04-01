<?php
namespace ViewComponents\ViewComponents;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Component\DataView;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Service\Services;

class HtmlBuilder
{
    /** @var ResourceManager  */
    protected $resourceManager;

    /**
     * Constructor.
     *
     * @param ResourceManager $resourceManager
     */
    public function __construct(ResourceManager $resourceManager = null)
    {
        $this->resourceManager = $resourceManager ?: Services::resourceManager();
    }

    public function a($href = '#', $text = '')
    {
        return new Tag('a', compact('href'), [new DataView($text)]);
    }

    public function js($src)
    {
        return $this->resourceManager->js($src);
    }

    public function css($src, array $attributes = [])
    {
        return $this->resourceManager->css($src, $attributes);
    }

    /**
     * @param $name
     * @param ComponentInterface[]|string $content
     * @param array $attributes
     * @return Tag
     */
    public function tag($name, $content = [], $attributes = [])
    {
        if (is_string($content)) {
            $content = [new DataView($content)];
        }
        return new Tag($name, $attributes, $content);
    }

    public function h1($content, $attributes = [])
    {
        return $this->tag('h1', $content, $attributes);
    }

    public function h2($content, $attributes = [])
    {
        return $this->tag('h2', $content, $attributes);
    }

    public function h3($content, $attributes = [])
    {
        return $this->tag('h3', $content, $attributes);
    }

    public function h4($content, $attributes = [])
    {
        return $this->tag('h4', $content, $attributes);
    }

    public function h5($content, $attributes = [])
    {
        return $this->tag('h5', $content, $attributes);
    }

    public function h6($content, $attributes = [])
    {
        return $this->tag('h6', $content, $attributes);
    }

    public function span($content, $attributes = [])
    {
        return $this->tag('span', $content, $attributes);
    }

    public function div($content, $attributes = [])
    {
        return $this->tag('div', $content, $attributes);
    }

    public function hr($attributes = [])
    {
        return $this->tag('hr', [], $attributes);
    }
}
