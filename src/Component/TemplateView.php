<?php

namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\ContainerComponentTrait;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Common\HasDataTrait;
use ViewComponents\ViewComponents\Rendering\RendererInterface;
use ViewComponents\ViewComponents\Service\Services;
use RuntimeException;

class TemplateView implements ViewComponentInterface, DataViewComponentInterface
{
    use HasDataTrait;
    use ContainerComponentTrait;

    /** @var  string */
    private $templateName;

    /** @var  RendererInterface */
    private $renderer;

    public function __construct($templateName, array $data = null, RendererInterface $renderer = null)
    {
        $this->setData($data ?: []);
        $this->templateName = $templateName;
        $this->setRenderer($renderer);
    }

    public function render()
    {
        return $this->getRenderer()->render($this->templateName, $this->getPreparedData());
    }

    /**
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
     * @param RendererInterface $renderer
     * @return $this
     */
    public function setRenderer(RendererInterface $renderer = null)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }


    /**
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
