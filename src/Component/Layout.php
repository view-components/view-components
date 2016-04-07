<?php

namespace ViewComponents\ViewComponents\Component;

use InvalidArgumentException;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Component\Layout\Section;
use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateInterface;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateTrait;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Service\Services;

/**
 * Layout is a template view component
 * with possibility to group children view components by sections.
 *
 */
class Layout extends Compound implements DataViewComponentInterface, ArrayDataAggregateInterface
{
    use ArrayDataAggregateTrait;

    const SECTION_MAIN = 'main';

    /** @var ResourceManager|null */
    private $resourceManager;

    /**
     * Layout constructor.
     *
     * @param TemplateView|string $template
     * @param array $data
     * @param ResourceManager|null $resourceManager (optional)
     */
    public function __construct(
        $template,
        array $data = [],
        ResourceManager $resourceManager = null
    ) {
        parent::__construct([]);
        $this->setData($data);
        $this->setTemplate($template);
        $this->resourceManager = $resourceManager;
    }

    /**
     * Sets layout template.
     *
     * @param TemplateView|string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        if (is_string($template)) {
            $template = new TemplateView($template);
        }
        $template->mergeData([
            'layout' => $this
        ]);
        $this->addChild(new Part($template, 'template'));
        return $this;
    }

    /**
     * Returns layout template.
     *
     * @return TemplateView
     */
    public function getTemplate()
    {
        return $this->getComponent('template');
    }

    /**
     * Returns section with specified name.
     *
     * @param string $name
     * @param bool $createIfNotExists
     * @return Section|null
     */
    public function section($name, $createIfNotExists = true)
    {
        $section = $this->getComponent('section-' . $name);
        if (!$section && $createIfNotExists) {
            $section = new Section($name);
            $section->attachToCompound($this);
        }
        return $section;
    }

    public function hasSection($name)
    {
        return $this->hasComponent('section-' . $name);
    }

    /**
     * Returns main section.
     *
     * @return ContainerComponentInterface
     */
    public function mainSection()
    {
        return $this->section(self::SECTION_MAIN);
    }

    /**
     * Places components to layout sections.
     *
     * @param array <string, ComponentInterface[]> $componentsBySections
     * @return $this
     */
    public function placeToSections(array $componentsBySections)
    {
        foreach ($componentsBySections as $section => $children) {
            if (!is_array($children)) {
                throw new InvalidArgumentException(
                    'Wrong argument format for Layout::placeToSections. Array of components for each section expected.'
                );
            }
            $this->section($section)->addChildren($children);
        }
        return $this;
    }

    /**
     * Returns component that renders html script tag for including specified javascript resource.
     * Returns component that renders empty string if resource was already included.
     *
     * @param string $name script URL or alias
     * @return Tag
     */
    public function js($name)
    {
        return $this->getResourceManager()->js($name);
    }

    /**
     * Returns component that renders html link tag for including specified css resource.
     * Returns component that renders empty string if resource was already included.
     *
     * @param string $name CSS URL or alias
     * @param array $attributes
     * @return Tag
     */
    public function css($name, array $attributes = [])
    {
        return $this->getResourceManager()->css($name, $attributes);
    }

    /**
     * Renders layout.
     *
     * @return string rendered layout
     */
    public function render()
    {
        $this->moveChildrenToMainSection();
        $this->getTemplate()
            ->mergeData($this->getData())
            ->mergeData(['layout' => $this]);
        return parent::render();
    }

    /**
     * Moves children attached directly to layout into main section
     * considering children position relatively to main section
     * (components before main section will be prepended
     * and components after main section will be appended).
     */
    protected function moveChildrenToMainSection()
    {
        $isNotPartFilter = function ($component) {
            return !$component instanceof PartInterface
            || !$this->getComponents()->contains($component);
        };
        // if main section exists, preserve components order
        if ($this->hasSection(self::SECTION_MAIN)) {
            $main = $this->mainSection();
            $template = $this->getComponent('template', false);
            $prependedChildren = $this->children()
                ->beforeItem($template)
                ->filter($isNotPartFilter);
            $appendedChildren =  $this->children()
                ->afterItem($template)
                ->filter($isNotPartFilter);
            $main->children()
                ->addMany($prependedChildren, true)
                ->addMany($appendedChildren, false);
        } else {
            $this->mainSection()->addChildren(
                $this->children()->filter($isNotPartFilter)
            );
        }
    }

    /**
     * Returns resource manager instance used by component.
     *
     * @return ResourceManager
     */
    protected function getResourceManager()
    {
        if ($this->resourceManager === null) {
            $this->resourceManager = Services::resourceManager();
        }
        return $this->resourceManager;
    }
}
