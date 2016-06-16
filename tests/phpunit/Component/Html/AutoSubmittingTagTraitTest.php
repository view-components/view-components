<?php

namespace ViewComponents\ViewComponents\Test\Component\Html;

use PHPUnit_Framework_TestCase;
use ViewComponents\ViewComponents\Base\Html\AutoSubmittingInputInterface;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Component\Html\Select;

class AutoSubmittingTagTraitTest extends PHPUnit_Framework_TestCase
{
    private $submitScriptMarker = '.submit';

    public function test()
    {
        $this->doTestComponent($this->makeComponent());
    }

    /**
     * @return ViewComponentInterface|AutoSubmittingInputInterface
     */
    protected function makeComponent()
    {
        return new Select();
    }

    /**
     * @param ViewComponentInterface|AutoSubmittingInputInterface $component
     */
    protected function doTestComponent($component)
    {
        self::assertTurnedOff($component);
        self::assertTurnedOn($component->enableAutoSubmitting());
        self::assertTurnedOff($component->disableAutoSubmitting());
        self::assertTurnedOn($component->setAutoSubmitting(true));
        self::assertTurnedOff($component->setAutoSubmitting(false));
    }

    /**
     * @param ViewComponentInterface|AutoSubmittingInputInterface $component
     */
    protected function assertTurnedOff($component)
    {
        self::assertNotContains($this->submitScriptMarker, $component->render());
        self::assertFalse($component->isAutoSubmitted());
        self::assertFalse($component->getAutoSubmitting());
    }

    /**
     * @param ViewComponentInterface|AutoSubmittingInputInterface $component
     */
    protected function assertTurnedOn($component)
    {
        self::assertContains($this->submitScriptMarker, $component->render());
        self::assertTrue($component->isAutoSubmitted());
        self::assertTrue($component->getAutoSubmitting());
    }
}