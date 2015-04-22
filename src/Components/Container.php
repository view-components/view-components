<?php
namespace Nayjest\ViewComponents\Components;

use Nayjest\ViewComponents\BaseComponents\AbstractContainer;

class Container extends AbstractContainer
{

    protected $openingText;

    protected $closingText;

    public function __construct(
        array $components = [],
        $opening = null,
        $closing = null
    )
    {
        parent::__construct($components);
        $this->setOpeningText($opening);
        $this->setClosingText($closing);
    }

    protected function renderOpening()
    {
        return $this->getOpeningText();
    }

    protected function renderClosing()
    {
        return $this->getClosingText();
    }

    /**
     * @return string|null
     */
    public function getOpeningText()
    {
        return $this->openingText;
    }

    /**
     * @param string|null $openingText
     * @return $this
     */
    public function setOpeningText($openingText)
    {
        $this->openingText = $openingText;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClosingText()
    {
        return $this->closingText;
    }

    /**
     * @param string|null $closingText
     * @return $this
     */
    public function setClosingText($closingText)
    {
        $this->closingText = $closingText;
        return $this;
    }
}
