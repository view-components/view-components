<?php
namespace ViewComponents\ViewComponents\Component\Html;

use ViewComponents\ViewComponents\Component\DataView;

class TagWithText extends Tag
{
    private $textComponent;

    /**
     * TagWithText constructor.
     *
     * @param string $tagName html tag name, optional, default value: 'div'
     * @param string $text tag contents (optional)
     * @param array $attributes html tag attributes (optional)
     */
    public function __construct(
        $tagName = 'div',
        $text = '',
        array $attributes = []
    ) {
        parent::__construct($tagName, $attributes, [$this->textComponent = new DataView($text)]);
    }

    /**
     * Returns inner text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->textComponent->getData();
    }

    /**
     * Sets inner text.
     *
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->textComponent->setData($text);
        return $this;
    }
}
