<?php
namespace Nayjest\ViewComponents;

use Nayjest\ViewComponents\Components\Html\A;
use Nayjest\ViewComponents\Components\Html\Tag;
use Nayjest\ViewComponents\Components\Text;
use Nayjest\ViewComponents\Resources\Resources;

class HtmlBuilder
{
    protected $resources;

    public function __construct(Resources $resources)
    {
        $this->resources = $resources;
    }

    public function a($href = '#', $text = '')
    {
        return new A(compact('href'), [new Text($text)]);
    }

    public function js($src)
    {
        return $this->resources->js($src);
    }

    public function css($src, array $attributes = [])
    {
        return $this->resources->css($src, $attributes);
    }

    public function tag($name, $content = [], $attributes = [])
    {
        if (is_string($content)) {
            $content = [new Text($content)];
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
