<?php
namespace Presentation\Framework\Component;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\DecoratedContainerTrait;
use Presentation\Framework\Rendering\ViewTrait;

class Container implements ComponentInterface
{
    use NodeTrait;
    use ViewTrait;
    use DecoratedContainerTrait;

    protected $openingText;

    protected $closingText;

    /**
     * @param array|\Traversable $children [optional]
     * @param null $openingText [optional]
     * @param null $closingText [optional]
     */
    public function __construct(
        $children = null,
        $openingText = null,
        $closingText = null
    )
    {
        if ($children !== null) {
            $this->children()->set($children);
        }
        $this->setOpeningText($openingText);
        $this->setClosingText($closingText);
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

    protected function renderOpening()
    {
        return $this->getOpeningText();
    }

    protected function renderClosing()
    {
        return $this->getClosingText();
    }
}
