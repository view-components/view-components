<?php

namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Data\DataAggregateTrait;
use ViewComponents\ViewComponents\Data\DataAggregateInterface;
use Traversable;

/**
 * CollectionView is a component for rendering data collections.
 *
 * CollectionView::render() iterates over its data collection,
 * injects data elements into children components and renders it for each data item.
 */
class CollectionView extends Container implements DataViewComponentInterface
{
    use DataAggregateTrait;
    /**
     * @var callable|null
     */
    private $dataInjector;

    /**
     * Constructor.
     * @param array|Traversable|null $dataCollection
     * @param array|ComponentInterface[] $components
     * @param callable|null $dataInjector
     */
    public function __construct(
        $dataCollection = null,
        $components = [],
        callable $dataInjector = null
    ) {
        parent::__construct($components);
        $this->setData($dataCollection ?: []);
        $this->dataInjector = $dataInjector;
    }

    /**
     * Renders component and returns output.
     *
     * @return string
     */
    public function render()
    {
        $out = '';
        foreach ($this->getData() as $row) {
            $this->injectData($row);
            $out .= parent::render();
        }
        return $out;
    }

    /**
     * @param callable|null $dataInjector
     * @return CollectionView
     */
    public function setDataInjector(callable $dataInjector = null)
    {
        $this->dataInjector = $dataInjector;
        return $this;
    }

    /**
     * @return callable|null
     */
    public function getDataInjector()
    {
        return $this->dataInjector;
    }

    protected function injectData($dataRow)
    {
        if ($this->dataInjector !== null) {
            call_user_func($this->dataInjector, $dataRow, $this);
        } else {
            foreach ($this->children() as $component) {
                if ($component instanceof DataAggregateInterface) {
                    $component->setData($dataRow);
                }
            }
        }
    }
}
