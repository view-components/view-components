<?php

namespace ViewComponents\ViewComponents\Customization\Bootstrap;

use LogicException;
use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\Html\AbstractTag;
use ViewComponents\ViewComponents\Base\Html\TagInterface;
use ViewComponents\ViewComponents\Component\CompoundBasicComponent;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Component\ManagedList\Control\FilterControl;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Customization\ExtendableCustomization;

class BootstrapStyling extends ExtendableCustomization
{

    protected $resourceManager;
    protected $options;

    public function __construct(ResourceManager $resources, BootstrapStylingOptions $options = null)
    {
        $this->options = $options ?: new BootstrapStylingOptions();
        $this->resourceManager = $resources;
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
        $this->extend(TemplateView::class, function (TemplateView $component) {
            $template = $component->getTemplateName();
            if (strpos($template, 'controls/') === 0) {
                $component->setTemplateName("twitter_bootstrap/$template");
            }
        });
        $this->extend(ManagedList::class, function (ManagedList $list) {
            $classes = [
                'form' => 'form-inline',
                'submit_button' => "btn btn-primary {$this->options->buttonSize}",
                // for grid
                // 'table' => $this->options->tableStyle
            ];
            foreach($classes as $componentId => $class) {
                $this->tryAddClass($list->getComponent($componentId), $class);
            }
        });
    }

    /**
     * @return BootstrapStylingOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

//    protected function tagCallback(TagInterface $tag)
//    {
//        /** @var Tag $tag */
//        $type = $tag->getAttribute('type');
//        switch ($tag->getTagName()) {
//            case 'select':
//                $this->customizeInput($tag);
//                break;
//            case 'input':
//                switch ($type) {
//                    case 'button':
//                        $this->customizeButton($tag);
//                        break;
//                    case 'submit':
//                        $this->customizeButton($tag, 'btn-primary');
//                        break;
//                    default:
//                        $this->customizeInput($tag);
//                }
//                break;
//            case 'button':
//                $this->customizeButton($tag);
//                break;
//            case 'a':
//                if ($tag->getAttribute('role') === 'button') {
//                    $this->customizeButton($tag);
//                }
//                break;
//            case 'table':
//                $this->customizeTable($tag);
//                break;
//        }
//
//        if ($tag->getAttribute('data-control') === 'pagination') {
//            $tag->onRender(function (ComponentInterface $component) {
//                if ($component->children()->isEmpty()) {
//                    return null;
//                }
//                $component->children()->first()->setAttribute('class', 'pagination');
//                /** @var Tag $item */
//                foreach ($component->getChildrenRecursive() as $item) {
//
//                    if ($item instanceof TagInterface
//                        && $item->getTagName() === 'li'
//                        && $item->getAttribute('data-disabled')
//                    ) {
//                        $item->setAttribute('class', 'disabled');
//                    }
//                }
//            });
//        }
//    }
//
//    protected function filterControlCallback(FilterControl $filter)
//    {
//        $view = $filter->getView();
//        $root = $filter->getRoot();
//        if (
//            !$view instanceof CompoundBasicComponent
//            || !$root
//            || !($form = $root->getComponent('form'))
//            || !$form instanceof TagInterface
//        ) {
//            return;
//        }
//        $form->setAttribute('class', 'form-inline');
//        $view->getComponent('container')
//            ->setTagName('div')
//            ->setAttribute('class', 'form-group');
//
//    }
//
//    protected function customizeInput(TagInterface $tag)
//    {
//        /** @var Tag|AbstractTag $tag */
//        $tag->setAttribute(
//            'class',
//            str_replace(
//                'from-control',
//                '',
//                $tag->getAttribute('class')
//            ) . 'form-control'
//        );
//    }
//
//
//    /**
//     * @param TagInterface $tag
//     * @param null|string $buttonStyle optional ('btn-default', 'btn-primary', etc)
//     */
//    protected function customizeButton(TagInterface $tag, $buttonStyle = null)
//    {
//        $buttonStyle = $buttonStyle ?: $this->options->buttonStyle;
//        /** @var Tag|AbstractTag $tag */
//        $tag->setAttribute(
//            'class',
//            $tag->getAttribute('class') .
//            "btn {$buttonStyle} {$this->options->buttonSize}"
//        );
//    }
//
//    protected function customizeTable(TagInterface $tag)
//    {
//        /** @var Tag|AbstractTag $tag */
//        $tag->setAttribute(
//            'class',
//            $tag->getAttribute('class') .
//            "{$this->options->tableStyle}"
//        );
//    }

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