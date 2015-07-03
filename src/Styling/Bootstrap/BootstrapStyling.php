<?php

namespace Nayjest\ViewComponents\Styling\Bootstrap;

use LogicException;
use Nayjest\ViewComponents\BaseComponents\ComponentInterface;
use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\Html\AbstractTag;
use Nayjest\ViewComponents\BaseComponents\Html\TagInterface;
use Nayjest\ViewComponents\Components\Controls\FilterControl;
use Nayjest\ViewComponents\Components\Html\Tag;
use Nayjest\ViewComponents\Resources\Resources;
use Nayjest\ViewComponents\Styling\CustomStyling;
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
            'Nayjest\ViewComponents\BaseComponents\Html\TagInterface' =>
                [
                    [
                        $this,
                        'tagCallback'
                    ]
                ],
            'Nayjest\ViewComponents\Components\Controls\FilterControl' => [
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
            case 'input':
                if ($type === 'button' || $type === 'submit') {
                    $this->customizeButton($tag);
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
            foreach ($view->components() as $child) {
                if ($child instanceof Tag && $child->getTagName() === 'input') {
                    $child->setAttribute('class', 'form-control');
                }
            }
        }
    }


    protected function customizeButton(TagInterface $tag)
    {
        /** @var Tag|AbstractTag $tag */
        $tag->setAttribute(
            'class',
            $tag->getAttribute('class') .
            "btn {$this->options->buttonStyle} {$this->options->buttonSize}"
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