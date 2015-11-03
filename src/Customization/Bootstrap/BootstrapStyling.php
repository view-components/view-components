<?php

namespace Presentation\Framework\Customization\Bootstrap;

use LogicException;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\Html\AbstractTag;
use Presentation\Framework\Base\Html\TagInterface;
use Presentation\Framework\Component\ManagedList\Control\View\FilterControlView;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\ManagedList\Control\FilterControl;
use Presentation\Framework\Resource\ResourceManager;
use Presentation\Framework\Customization\ConfigurableCustomization;

class BootstrapStyling extends ConfigurableCustomization
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
     * @param ComponentInterface $resourceRoot root component for JS & CSS
     */
    public function apply(ComponentInterface $component, ComponentInterface $resourceRoot = null)
    {
        $this->addResources($resourceRoot ?: $component);
        parent::apply($component);
    }

    protected function addResources(ComponentInterface $container)
    {
        if (!$container->children()->isWritable()) {
            throw new LogicException('Styling must be applied to writable container');
        }
        $container
            ->children()
            ->add($this->resourceManager->js('jquery'))
            ->add($this->resourceManager->css($this->options->cssFile))
            ->add($this->resourceManager->js($this->options->jsFile));
    }

    protected function initializeCallbacks()
    {
        $this->register(TagInterface::class, [$this, 'tagCallback']);
        $this->register(FilterControl::class, [$this, 'filterControlCallback']);
    }

    /**
     * @return BootstrapStylingOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    protected function tagCallback(TagInterface $tag)
    {
        /** @var Tag $tag */
        $type = $tag->getAttribute('type');
        switch ($tag->getTagName()) {
            case 'select':
                $this->customizeInput($tag);
                break;
            case 'input':
                switch($type) {
                    case 'button':
                        $this->customizeButton($tag);
                        break;
                    case 'submit':
                        $this->customizeButton($tag, 'btn-primary');
                        break;
                    default:
                        $this->customizeInput($tag);
                }
                break;
            case 'button':
                $this->customizeButton($tag);
                break;
            case 'a':
                if ($tag->getAttribute('role') === 'button') {
                    $this->customizeButton($tag);
                }
                break;
            case 'table':
                $this->customizeTable($tag);
                break;
        }

        if ($tag->getAttribute('data-control') === 'pagination') {
            $tag->onRender(function(ComponentInterface $component) {
                if ($component->children()->isEmpty()) {
                    return null;
                }
                $component->children()->first()->setAttribute('class','pagination');
                /** @var Tag $item */
                foreach($component->getChildrenRecursive() as $item) {

                    if ($item instanceof TagInterface
                        &&  $item->getTagName() === 'li'
                        &&  $item->getAttribute('data-disabled')
                    ) {
                        $item->setAttribute('class', 'disabled');
                    }
                }
            });
        }
    }

    protected function filterControlCallback(FilterControl $filter)
    {
        $view = $filter->getView();
        if ($view instanceof TagInterface) {
            $view->setTagName('div');
            $view->setAttribute('class', 'form-group');
            $parent = $filter->parent();
            if ($parent instanceof TagInterface && $parent->getTagName() === 'form') {
                $parent->setAttribute('class', 'form-inline');
            }
        }
    }

    protected function customizeInput(TagInterface $tag)
    {
        /** @var Tag|AbstractTag $tag */
        $tag->setAttribute(
            'class',
            str_replace(
                'from-control',
                '',
                $tag->getAttribute('class')
            ). 'form-control'
        );
    }


    /**
     * @param TagInterface $tag
     * @param null|string $buttonStyle optional ('btn-default', 'btn-primary', etc)
     */
    protected function customizeButton(TagInterface $tag, $buttonStyle = null)
    {
        $buttonStyle = $buttonStyle?:$this->options->buttonStyle;
        /** @var Tag|AbstractTag $tag */
        $tag->setAttribute(
            'class',
            $tag->getAttribute('class') .
            "btn {$buttonStyle} {$this->options->buttonSize}"
        );
    }

    protected function customizeTable(TagInterface $tag)
    {
        /** @var Tag|AbstractTag $tag */
        $tag->setAttribute(
            'class',
            $tag->getAttribute('class') .
            "btn {$this->options->tableStyle}"
        );
    }
}