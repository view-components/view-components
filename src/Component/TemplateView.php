<?php

namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentTrait;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateInterface;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateTrait;
use ViewComponents\ViewComponents\Rendering\RendererInterface;
use ViewComponents\ViewComponents\Service\Services;
use RuntimeException;

class TemplateView implements DataViewComponentInterface, ContainerComponentInterface, ArrayDataAggregateInterface
{
    use ArrayDataAggregateTrait;
    use ContainerComponentTrait;

    /** @var  string */
    private $templateName;

    /** @var  RendererInterface */
    private $renderer;

    /**
     * Constructor.
     *
     * @param string|null $templateName
     * @param array|null $data view data
     * @param RendererInterface|null $renderer
     */
    public function __construct($templateName = null, array $data = null, RendererInterface $renderer = null)
    {
        $this->setData($data ?: []);
        $this->templateName = $templateName;
        $this->setRenderer($renderer);
    }

    /**
     * Renders component and returns output.
     *
     * @return string
     */
    public function render()
    {
        return $this->getRenderer()->render(
            $this->getTemplateName(),
            $this->getPreparedData()
        );
    }

    /**
     * Returns renderer instance used to render template.
     *
     * @return RendererInterface
     */
    public function getRenderer()
    {
        if ($this->renderer === null) {
            $this->renderer = Services::renderer();
        }
        return $this->renderer;
    }

    /**
     * Sets renderer.
     *
     * @param RendererInterface $renderer
     * @return $this
     */
    public function setRenderer(RendererInterface $renderer = null)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * Returns template name.
     *
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * Sets template.
     *
     * @param string $templateName
     * @return $this
     */
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
        return $this;
    }

    private function getPreparedData()
    {
        $data = $this->getData();
        if (array_key_exists('component', $data)) {
            throw new RuntimeException('Usage of reserved \'component\' key in view data');
        }
        $data['component'] = $this;
        return $data;
    }
}
