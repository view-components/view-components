<?php
namespace Nayjest\ViewComponents\Components;

use Nayjest\ViewComponents\BaseComponents\Container as BaseContainer;

class Container extends BaseContainer
{

    protected $opening_text;

    protected $closing_text;

    public function __construct($opening = null, $closing = null, array $components = [])
    {
        parent::__construct($components);
        if ($opening !== null) $this->setOpeningText($opening);
        if ($closing !== null) $this->setClosingText($closing);
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
        return $this->opening_text;
    }

    /**
     * @param string|null $opening_text
     * @return $this
     */
    public function setOpeningText($opening_text)
    {
        $this->opening_text = $opening_text;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClosingText()
    {
        return $this->closing_text;
    }

    /**
     * @param string|null $closing_text
     * @return $this
     */
    public function setClosingText($closing_text)
    {
        $this->closing_text = $closing_text;
        return $this;
    }
}
