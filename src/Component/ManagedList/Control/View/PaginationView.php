<?php

namespace Presentation\Framework\Component\ManagedList\Control\View;

use Closure;
use League\Url\Query;
use League\Url\Url;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Text;

/**
 * Class PaginationView
 *
 * @internal
 */
class PaginationView extends Tag
{

    private $items = [];
    /**
     * @var int
     */
    private $current;
    /**
     * @var int
     */
    private $total;
    /**
     * @var array|null
     */
    private $inputKey;

    /**
     * @param int $current
     * @param int|Closure $total
     * @param string $inputKey
     */
    public function __construct($current, $total, $inputKey)
    {
        parent::__construct(
            'nav',
            [
                'data-role' => 'control-container',
                'data-control' => 'pagination',
            ]
        );
        $this->current = (int)$current;
        $this->total = is_numeric($total) ? (int)$total : $total;
        $this->inputKey = $inputKey;
        if (!$total instanceof Closure) {
            $this->initializeChildren();
        }
    }

    protected function initializeChildren()
    {
        $this->makeLinks();
        $this->children()->set([new Tag('ul', [], $this->items)]);
    }

    public function render()
    {
        if ($this->total instanceof Closure) {
            $closure = $this->total;
            $this->total = (int)($closure());
            $this->initializeChildren();
        }
        // hide if there is no need in pagination
        if ($this->total <= 1) {
            $this->setAttribute('style', 'display:none;');
        }
        return parent::render();
    }
    protected function makeLinks()
    {
        $maxLinks = 10;
        $minNumLinksAroundCurrent = 2;
        $minNumLinksNearEnd = 1;
        // without prev & next links
        $maxNumLinks = $maxLinks - 2;
        $this->makeLink(1, '«');
        if ($this->total <= $maxNumLinks) {
            $this->makeLinksRange(1, $this->total);
        } else {
            // 1 separator after current page item
            if (($this->current + $minNumLinksAroundCurrent) < $maxLinks) {
                $this->makeLinksRange(
                    1,
                    $this->current + $minNumLinksAroundCurrent
                );
                $this->makeSeparator();
                $this->makeLinksRange(
                    $this->total - $minNumLinksNearEnd,
                    $this->total
                );
                // 1 separator before current page item
            } elseif ($this->total - ($this->current - $minNumLinksAroundCurrent) < $maxLinks) {
                $this->makeLinksRange(1, 1 + $minNumLinksNearEnd);
                $this->makeSeparator();
                $this->makeLinksRange(
                    $this->current - $minNumLinksAroundCurrent,
                    $this->total
                );
                // 2 separators
            } else {
                $this->makeLinksRange(1, 1 + $minNumLinksNearEnd);
                $this->makeSeparator();
                $this->makeLinksRange(
                    $this->current - $minNumLinksAroundCurrent,
                    $this->current + $minNumLinksAroundCurrent
                );
                $this->makeSeparator();
                $this->makeLinksRange(
                    $this->total - $minNumLinksNearEnd,
                    $this->total
                );
            }
        }
        $this->makeLink($this->total, '»');
    }

    /**
     * @param int $page
     * @param null|string $title
     */
    protected function makeLink($page, $title = null)
    {

        $title = $title ?: (string)$page;
        $text = new Text((string)$title);

        $disabled = ($page === $this->current);
        $this->items[] = new Tag('li', $disabled ? ['data-disabled' => 1] : [], [
            new Tag(
                $disabled ? 'span' : 'a',
                $disabled ? [] : ['href' => $this->makeUrl($page)],
                [$text]
            )
        ]);
    }

    protected function makeSeparator()
    {
        $this->items[] = new Tag('li', [], [
            new Tag('span', [], [new Text('...')])
        ]);
    }

    protected function makeLinksRange($from, $to)
    {
        for ($page = $from; $page <= $to; $page++) {
            $this->makeLink($page);
        }
    }

    protected function makeUrl($page)
    {

        $url = Url::createFromServer($_SERVER);
        // league/url v4.X
        if (method_exists($url, 'mergeQuery')) {
            return (string)$url->mergeQuery(
                Query::createFromArray([$this->inputKey => $page])
            );
        // league/url v3.X
        } else {
            $url->getQuery()->modify([$this->inputKey => $page]);
            return (string)$url;
        }
    }
}
