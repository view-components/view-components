<?php

namespace Presentation\Framework\Styling\Bootstrap;

use LogicException;
use Presentation\Framework\BaseComponents\ComponentInterface;
use Presentation\Framework\BaseComponents\ContainerInterface;
use Presentation\Framework\BaseComponents\Html\AbstractTag;
use Presentation\Framework\BaseComponents\Html\TagInterface;
use Presentation\Framework\Components\Controls\FilterControl;
use Presentation\Framework\Components\Html\Tag;
use Presentation\Framework\Resources\Resources;
use Presentation\Framework\Styling\CustomStyling;
use Symfony\Component\VarDumper\VarDumper;

class BootstrapStyling extends CustomStyling
{

    protected $resources;
    protected $options;

    public function __construct(Resources $resources, BootstrapStylingOptions $options = null)
    {
        $this->options = $options ?: new BootstrapStylingOptions();
        $this->resources = $resources;
        parent::__construct($this->getCallbacks());
    }

    /**
     * @param ComponentInterface|ContainerInterface $component
     * @param ContainerInterface $resourcesContainer
     */
    public function apply(ComponentInterface $component, ContainerInterface $resourcesContainer = null)
    {
        $resourcesContainer = $resourcesContainer ?: $component;
        if (!$resourcesContainer instanceof ContainerInterface) {
            throw new LogicException('Styling must be applied to container');
        }
        $this->addResources($resourcesContainer);
        parent::apply($component);
    }

    protected function addResources(ContainerInterface $container)
    {
        $container->components()->add(
            $this->resources->js('jquery')
        );
        $container->components()->add(
            $this->resources->css($this->options->cssFile)
        );
        $container->components()->add(
            $this->resources->js($this->options->jsFile)
        );
    }

    protected function getCallbacks()
    {

        return [
            'Presentation\Framework\BaseComponents\Html\TagInterface' =>
                [
                    [
                        $this,
                        'tagCallback'
                    ]
                ],
            'Presentation\Framework\Components\Controls\FilterControl' => [
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
    }

    protected function filterControlCallback(FilterControl $component)
    {
        $view = $component->getView();
        if ($view instanceof Tag) {
            $view->setTagName('div');
            $view->setAttribute('class', 'form-group');
            $component->getParent()->setAttribute('class', 'form-inline');
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