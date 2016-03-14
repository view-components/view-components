<?php

namespace ViewComponents\ViewComponents\Customization\Bootstrap;

use LogicException;
use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\Html\TagInterface;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Customization\ExtendableCustomization;
use ViewComponents\ViewComponents\Service\Services;

class BootstrapStyling extends ExtendableCustomization
{

    protected $resourceManager;
    protected $options;

    public function __construct(BootstrapStylingOptions $options = null, ResourceManager $resources = null)
    {
        $this->options = $options ?: new BootstrapStylingOptions();
        $this->resourceManager = $resources ?: Services::resourceManager();
        $this->initializeCallbacks();
    }

    /**
     * @param ComponentInterface $component
     * @param ContainerComponentInterface $resourceRoot root component for JS & CSS
     * @return void
     */
    public function apply(ComponentInterface $component, ContainerComponentInterface $resourceRoot = null)
    {
        if (!$resourceRoot) {
            if (!$component instanceof ContainerComponentInterface) {
                throw new LogicException('Styling must be applied to writable container');
            }
        }
        $this->addResources($resourceRoot ?: ($component));
        parent::apply($component);
    }

    protected function addResources(ContainerComponentInterface $container)
    {
        $container
            ->children()
            ->add($this->resourceManager->js('jquery'))
            ->add($this->resourceManager->css($this->options->cssFile))
            ->add($this->resourceManager->js($this->options->jsFile));
    }

    protected function initializeCallbacks()
    {
        $options = $this->getOptions();
        $this->extend(TemplateView::class, function (TemplateView $component) use ($options) {
            $template = $component->getTemplateName();
            if (strpos($template, 'controls/') === 0) {
                $component->setTemplateName("twitter_bootstrap/$template");
                $component->mergeData([
                    'input_class' => "$options->inputStyle $options->inputSize"
                ]);
            }
        });
        $this->extend(ManagedList::class, function (ManagedList $list) {
            $classes = [
                'form' => 'form-inline',
                'submit_button' => "btn btn-primary {$this->options->buttonSize}",
                'table' => $this->options->tableStyle
            ];
            foreach ($classes as $componentId => $class) {
                $this->tryAddClass($list->getComponent($componentId), $class);
            }
        });

        $this->extend(Tag::class, function (Tag $tag) {
            $classes = [
                'button' => "btn {$this->options->buttonStyle} {$this->options->buttonSize}",
                'table' => $this->options->tableStyle
            ];
            if (!array_key_exists($tag->getTagName(), $classes)) {
                return;
            }
            $this->tryAddClass($tag, $classes[$tag->getTagName()]);
        });
    }

    /**
     * @return BootstrapStylingOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param TagInterface|ComponentInterface $tag
     * @param $class
     */
    protected function tryAddClass($tag, $class)
    {
        if (!$tag instanceof TagInterface) {
            return;
        }
        $tag->setAttribute(
            'class',
            str_replace($class, '', $tag->getAttribute('class', '')) . " $class"
        );
    }
}
