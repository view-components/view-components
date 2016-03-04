<?php

namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Common\HasDataTrait;
use ViewComponents\ViewComponents\Data\DataAcceptorInterface;
use Traversable;

/**
 * View component for collection of items.
 */
class CollectionView extends Container implements DataViewComponentInterface
{
    use HasDataTrait;
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
                if ($component instanceof DataAcceptorInterface) {
                    $component->setData($dataRow);
                }
            }
        }
    }
}
