<?php

namespace ViewComponents\ViewComponents\Component\Control\View;

use ViewComponents\ViewComponents\Common\UriFunctions;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Rendering\RendererInterface;

class PaginationControlView extends TemplateView
{
    /** @var string */
    private $linkTemplateName;

    private $control;

    public function __construct(
        $templateName = 'controls/pagination',
        $linkTemplateName = 'controls/pagination/link',
        RendererInterface $renderer = null
    ) {
        parent::__construct($templateName, [], $renderer);
        $this->linkTemplateName = $linkTemplateName;
    }

    /**
     * @return string
     */
    public function getLinkTemplateName()
    {
        return $this->linkTemplateName;
    }

    /**
     * @param $linkTemplateName
     * @return $this
     */
    public function setLinkTemplateName($linkTemplateName)
    {
        $this->linkTemplateName = $linkTemplateName;
        return $this;
    }

    /**
     * @return PaginationControl
     */
    protected function getControl()
    {
        if ($this->control === null) {
            if ($this->parent() instanceof PaginationControl) {
                $this->control = $this->parent();
            } else {
                $this->control = $this->parents()->filterByType(PaginationControl::class);
            }
        }
        return $this->control;
    }

    public function renderLink($pageNumber, $title = null)
    {
        $title = $title ?: (string)$pageNumber;
        return $this->getRenderer()->render($this->linkTemplateName, [
            'isCurrent' => $this->getControl()->getCurrentPage() == $pageNumber,
            'url' => $this->makeUrl($pageNumber),
            'title' => $title ?: (string)$pageNumber
        ]);
    }

    /**
     * @param int $from
     * @param int $to
     * @return string
     */
    public function renderLinksRange($from, $to)
    {
        $out = '';
        for ($pageNumber = $from; $pageNumber <= $to; $pageNumber++) {
            $out .= $this->renderLink($pageNumber);
        }
        return $out;
    }

    /**
     * @param int|string $pageNumber
     * @return string
     */
    protected function makeUrl($pageNumber)
    {
        $urlKey = $this->getControl()->getPageInputOption()->getKey();
        return UriFunctions::replaceFragment(
            UriFunctions::modifyQuery(null, [$urlKey => $pageNumber]),
            ''
        );
    }
}
