<?php

namespace ViewComponents\ViewComponents\Customization\Configurable;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Customization\AbstractRecursiveCustomization;
use ViewComponents\ViewComponents\Resource\ResourceManager;

class Customization extends AbstractRecursiveCustomization
{

    protected $helper;
    protected $selector;
    protected $actions = [];
    protected $processor;
    /**
     * @var array
     */
    private $config;

    /**
     * Constructor.
     *
     * @param array $config
     * @param ResourceManager|null $resourceManager
     */
    public function __construct(array $config, ResourceManager $resourceManager = null)
    {
        $this->helper = new Helper($resourceManager);
        $this->selector = new TargetSelector();
        $this->config = $config;
        $this->processor = new OperationProcessor($this->helper);
    }

    /**
     * Applies customization to target component and its children.
     *
     * @param ComponentInterface $component
     */
    public function apply(ComponentInterface $component)
    {
        /**
         * isRootOfCustomizations property used in TargetSelector
         * @see TargetSelector::checkRootCondition
         */
        $component->isRootOfCustomizations = true;
        parent::apply($component);
        unset($component->isRootOfCustomizations);
    }

    protected function applyInternal(ComponentInterface $component)
    {
        foreach ($this->config as $selector => $operations) {
            if ($this->selector->check($selector, $component)) {
                $this->processor->apply($component, $operations);
            }
        }
    }
}
