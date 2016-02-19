<?php

namespace ViewComponents\ViewComponents\Component\Control\View;

use League\Url\Components\Query;
use League\Url\Url;
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
        $url = Url::createFromServer($_SERVER);
        $urlKey = $this->getControl()->getPageInputOption()->getKey();
        // league/url v4.X
        if (method_exists($url, 'mergeQuery')) {
            return (string)$url->mergeQuery(
                Query::createFromArray([$urlKey => $page])
            );
            // league/url v3.X
        } else {
            $url->getQuery()->modify([$urlKey => $page]);
            return (string)$url;
        }
    }
}