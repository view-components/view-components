<?php

namespace ViewComponents\ViewComponents\Component;

use InvalidArgumentException;
use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Common\HasDataTrait;
use ViewComponents\ViewComponents\Data\DataAcceptorInterface;

/**
 * Layout is a template view component
 * with possibility to group children view components by sections.
 *
 */
class Layout extends Compound implements DataAcceptorInterface
{
    use HasDataTrait;

    const SECTION_MAIN = 'main';

    /**
     * Layout constructor.
     *
     * @param TemplateView|string $template
     * @param array $data
     */
    public function __construct($template, array $data = [])
    {
        parent::__construct([]);
        $this->setData($data);
        $this->setTemplate($template);
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
     * @return ContainerComponentInterface
     */
    public function section($name)
    {
        $sectionObject = $this->getComponent('section-' . $name);
        if (!$sectionObject) {
            $this->addChild(
                new Part(
                    $sectionObject = new Container(),
                    'section-' . $name, 'template'
                )
            );
        }
        return $sectionObject;
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
     * @param array<string, ComponentInterface[]> $componentsBySections
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
}
