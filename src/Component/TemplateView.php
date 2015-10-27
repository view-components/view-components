<?php

namespace Presentation\Framework\Component;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Data\DataAcceptorInterface;
use Presentation\Framework\Rendering\RendererInterface;
use Presentation\Framework\Rendering\ViewTrait;

class TemplateView implements ComponentInterface, DataAcceptorInterface
{
    use NodeTrait;
    use ComponentTrait {
        ComponentTrait::render as private internalRender;
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

    public function __construct(RendererInterface $renderer = null, $templateName = '', $viewData = [])
    {

        $this->renderer = $renderer;
        $this->templateName = $templateName;
        $this->data = $viewData;
    }

    public function render()
    {
        return $this->beforeRender()->notify()
        . $this->renderer->render($this->templateName, array_merge($this->data, ['this' => $this]));
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
}