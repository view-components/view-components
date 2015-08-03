<?php

namespace Presentation\Framework\Styling\Bootstrap;

use LogicException;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ContainerInterface;
use Presentation\Framework\Base\Html\AbstractTag;
use Presentation\Framework\Base\Html\TagInterface;
use Presentation\Framework\Component\Controls\FilterControl;
use Presentation\Framework\Component\ControlView\FilterControlView;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Resources\ResourceManager;
use Presentation\Framework\Styling\CustomStyling;
use Symfony\Component\VarDumper\VarDumper;

class BootstrapStyling extends CustomStyling
{

    protected $resources;
    protected $options;

    public function __construct(ResourceManager $resources, BootstrapStylingOptions $options = null)
    {
        $this->options = $options ?: new BootstrapStylingOptions();
        $this->resources = $resources;
        parent::__construct($this->getCallbacks());
    }

    /**
     * @param ComponentInterface|ContainerInterface $component
     * @param ComponentInterface $resourcesContainer
     */
    public function apply(ComponentInterface $component, ComponentInterface $resourcesContainer = null)
    {
        $resourcesContainer = $resourcesContainer ?: $component;
        if (!$resourcesContainer->children()->isWritable()) {
            throw new LogicException('Styling must be applied to writable container');
        }
        $this->addResources($resourcesContainer);
        parent::apply($component);
    }

    protected function addResources(ComponentInterface $container)
    {
        $container
            ->children()
            ->add($this->resources->js('jquery'))
            ->add($this->resources->css($this->options->cssFile))
            ->add($this->resources->js($this->options->jsFile));
    }

    protected function getCallbacks()
    {

        return [
            'Presentation\Framework\Base\Html\TagInterface' =>
                [
                    [
                        $this,
                        'tagCallback'
                    ]
                ],
            'Presentation\Framework\Component\ControlView\FilterControlView' => [
                [
                    $this,
                    'filterControlCallback'
                ]
            ]
        ];
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
            if ($tag->children()->isEmpty()) {
                return null;
            }
            $tag->children()->first()->setAttribute('class','pagination');
            /** @var Tag $item */
            foreach($tag->getChildrenRecursive() as $item) {

                if ($item instanceof TagInterface
                    &&  $item->getTagName() === 'li'
                    &&  $item->getAttribute('data-disabled')
                ) {
                    $item->setAttribute('class', 'disabled');
                }
            }
        }

    }

    protected function filterControlCallback(FilterControlView $view)
    {

        if ($view instanceof TagInterface) {
            $view->setTagName('div');
            $view->setAttribute('class', 'form-group');
            if ($view->parent() instanceof TagInterface) {
                $view->parent()->setAttribute('class', 'form-inline');
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