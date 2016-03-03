<?php

namespace ViewComponents\ViewComponents\Component;

use InvalidArgumentException;
use ViewComponents\ViewComponents\Component\Layout\Section;
use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Common\HasDataTrait;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Data\DataAcceptorInterface;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use ViewComponents\ViewComponents\Service\Services;

/**
 * Layout is a template view component
 * with possibility to group children view components by sections.
 *
 */
class Layout extends Compound implements DataAcceptorInterface
{
    use HasDataTrait;

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
    )
    {
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
        $template->setData([
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
     * @param $name
     * @return Section
     */
    public function section($name)
    {
        $section = $this->getComponent('section-' . $name);
        if (!$section) {
            $section = new Section($name);
            $section->attachToCompound($this);
        }
        return $section;
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
     * Moves children attached directly to layout into main section.
     */
    protected function moveChildrenToMainSection()
    {
        foreach ($this->children() as $component) {
            if ($component instanceof PartInterface && $this->getComponents()->contains($component)) {
                continue;
            }
            $component->attachTo($this->section(self::SECTION_MAIN));
        }
    }

    /**
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
