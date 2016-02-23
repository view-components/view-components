<?php

namespace ViewComponents\ViewComponents\Component\Control\View;

use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Rendering\RendererInterface;
use League\Uri\Schemes\Http as HttpUri;

class PaginationControlView extends TemplateView
{
    /** @var string */
    private $linkTemplateName;

    private $control;

    public function __construct(
        $templateName = 'controls/pagination',
        $linkTemplateName = 'controls/pagination/link',
        RendererInterface $renderer = null
    )
    {
        parent::__construct($templateName, [], $renderer);
        $this->linkTemplateName = $linkTemplateName;
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

    public function renderLink($page, $title = null)
    {
        $title = $title ?: (string)$page;
        return $this->getRenderer()->render($this->linkTemplateName, [
            'isCurrent' => $this->getControl()->getCurrentPage() == $page,
            'url' => $this->makeUrl($page),
            'title' => $title ?: (string)$page
        ]);
    }

    public function renderLinksRange($from, $to)
    {
        $out = '';
        for ($page = $from; $page <= $to; $page++) {
            $out .= $this->renderLink($page);
        }
        return $out;
    }

    protected function makeUrl($page)
    {
        $url = HttpUri::createFromServer($_SERVER);
        $urlKey = $this->getControl()->getPageInputOption()->getKey();
        $query = $url->query->merge(http_build_query([$urlKey => $page]));
        return (string)$url->withQuery((string)$query);
    }
}