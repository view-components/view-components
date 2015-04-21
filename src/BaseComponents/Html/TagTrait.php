<?php
namespace Nayjest\ViewComponents\BaseComponents\Html;

/**
 * Class TagTrait
 *
 * Implements abstract methods from base container
 * and common functionality of html tags.
 *
 * @package Nayjest\ViewComponents\Components\Base\Html
 */
trait TagTrait
{

    abstract public function getTagName();

    /**
     * HTML tag attributes.
     * Keys are attribute names and values are attribute values.
     * @var array
     */
    protected $attributes = [];

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

    public function getAttribute($name, $default = null)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        } else {
            return $default;
        }
    }

    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
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