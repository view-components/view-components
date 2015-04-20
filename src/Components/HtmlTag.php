<?php
namespace Nayjest\ViewComponents\Components;

use Nayjest\ViewComponents\Components\Base\Container;

class HtmlTag extends Container
{

    protected $tag_name;

    /**
     * HTML tag attributes.
     * Keys are attribute names and values are attribute values.
     * @var array
     */
    protected $attributes = [];


    /**
     * @param string|null $tagName
     * @param array|null $attributes
     * @param array $components
     */
    public function __construct(
        $tagName = null,
        $attributes = null,
        array $components = []
    )
    {
        if ($tagName !== null) {
            $this->setTagName($tagName);
        }
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }
        parent::__construct($components);
    }

    /**
     * Allows to specify HTML tag.
     *
     * @param string $name
     * @return $this
     */
    public function setTagName($name)
    {
        $this->tag_name = $name;
        return $this;
    }

    /**
     * Returns HTML tag.
     *
     * @return string
     */
    public function getTagName()
    {
        return $this->tag_name ?: $this->suggestTagName();
    }

    /**
     * Suggests tag name by class name.
     *
     * @return string
     */
    private function suggestTagName()
    {
        $class_name = get_class($this);
        $parts = explode('\\', $class_name);
        $base_name = array_pop($parts);
        return ($base_name === 'HtmlTag') ? 'div' : strtolower($base_name);
    }

    /**
     * Sets html tag attributes.
     * Keys are attribute names and values are attribute values.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes = [])
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function addAttributes(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    /**
     * Returns html tag attributes.
     * Keys are attribute names and values are attribute values.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Renders opening tag.
     *
     * @return string
     */
    protected function renderOpening()
    {
        /** @var \Illuminate\Html\HtmlBuilder $html */

        return '<'
        . $this->getTagName()
        . $this->renderAttributes()
        . '>';
    }

    /**
     * Renders closing tag.
     *
     * @return string
     */
    protected function renderClosing()
    {
        return "</{$this->getTagName()}>";
    }

    protected function renderAttributes()
    {
        $html = [];
        foreach ($this->attributes as $key => $value) {
            $escaped = htmlentities($value, ENT_QUOTES, 'UTF-8', false);
            $html[] = is_numeric($key) ?
                ($escaped . '="' . $escaped . '""')
                :
                ("$key=\"$escaped\"");
        }
        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }
}
