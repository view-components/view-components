<?php

namespace Presentation\Framework\Component;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Data\DataAcceptorInterface;
use Presentation\Framework\Rendering\RendererInterface;
use Presentation\Framework\Rendering\ViewTrait;
use Presentation\Framework\Service\Services;

class TemplateView implements ComponentInterface, DataAcceptorInterface
{
    use NodeTrait;
    use ComponentTrait {
        ComponentTrait::render as private internalRender;
        ComponentTrait::renderChildren as private renderChildrenInternal;
    }
    use ViewTrait;

    /**
     * @var RendererInterface
     */
    protected $renderer;
    /**
     * @var
     */
    protected $templateName;
    /**
     * @var
     */
    protected $data;

    private $wasChildrenRendered = false;

    /**
     * TemplateView constructor.
     *
     * @param string $templateName
     * @param array $viewData
     * @param RendererInterface|null $renderer
     */
    public function __construct($templateName = '', $viewData = [], RendererInterface $renderer = null)
    {
        $this->renderer = $renderer;
        $this->templateName = $templateName;
        $this->data = $viewData;
    }

    public function render()
    {
        $this->emit('render', [$this]);
        if (!$this->isVisible()) {
            return '';
        }
        $this->wasChildrenRendered = false;
        if (!$this->renderer) {
            $this->setRenderer(Services::renderer());
        }
        $output = $this->renderer->render(
            $this->templateName,
            array_merge($this->data, ['this' => $this])
        );
        if (!$this->wasChildrenRendered) {
            $output .= $this->renderChildren();
        }
        return $output;
    }

    /**
     * @return RendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * @param RendererInterface $renderer
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return mixed
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @param mixed $templateName
     */
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function renderChildren()
    {
        $this->wasChildrenRendered = true;
        return $this->renderChildrenInternal();
    }
}
