<?php
namespace ViewComponents\ViewComponents\Base\Html;

/**
 * Class TagTrait
 *
 * TagTrait implements abstract methods
 * from \ViewComponents\ViewComponents\Base\DecoratedContainerTrait
 * and common functionality of html tags.
 */
trait TagTrait
{
    abstract public function getTagName();

    public static function renderAttributes(array $attributes)
    {
        $html = [];
        foreach ($attributes as $key => $value) {
            $escaped = htmlentities($value, ENT_QUOTES, 'UTF-8', false);
            $html[] = is_numeric($key) ?
                ($escaped . '="' . $escaped . '""')
                :
                ("$key=\"$escaped\"");
        }
        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }

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
        return '<'
        . $this->getTagName()
        . static::renderAttributes($this->getAttributes())
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
}
