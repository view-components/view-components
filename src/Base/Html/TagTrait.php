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

    private static $emptyTagNames = [
        'link',
        'track',
        'param',
        'area',
        'command',
        'col',
        'base',
        'meta',
        'hr',
        'source',
        'img',
        'keygen',
        'br',
        'wbr',
        'colgroup', # when the span is present
        'input',
        'frame',
        'basefont',
        'isindex'
    ];


    /**
     * HTML tag attributes.
     * Keys are attribute names and values are attribute values.
     * @var array
     */
    protected $attributes = [];

    /**
     * Renders HTML tag attributes.
     *
     * @param array $attributes
     * @return string
     */
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
     * Returns names of empty tags (br, hr, etc.).
     *
     * @return array
     */
    public static function getEmptyTagNames()
    {
        return self::$emptyTagNames;
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
     * Returns HTML tag attribute by name.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        } else {
            return $default;
        }
    }

    /**
     * Sets HTML tag attribute.
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
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

    /**
     * Adds attributes to HTML tag.
     * New attributes overwrites existing with same names.
     *
     * @param array $attributes
     * @return $this
     */
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
        . ($this->isEmptyTag() ? '/' : '')
        . '>';
    }

    /**
     * Renders closing tag.
     *
     * @return string
     */
    protected function renderClosing()
    {
        return $this->isEmptyTag() ? '' : "</{$this->getTagName()}>";
    }

    protected function isEmptyTag()
    {
        return in_array($this->getTagName(), static::getEmptyTagNames());
    }
}
