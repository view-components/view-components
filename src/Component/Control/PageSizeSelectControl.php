<?php

namespace ViewComponents\ViewComponents\Component\Control;

use Nayjest\Tree\Utils;
use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Component\Compound;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Data\DataAggregateInterface;
use ViewComponents\ViewComponents\Data\Operation\DummyOperation;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Input\InputOption;

class PageSizeSelectControl extends Part implements ControlInterface
{

    /** @var int[] */
    private $variants;

    /** @var  PaginationControl|null */
    private $paginationControl;

    /**
     * @var InputOption
     */
    private $inputOption;

    public function __construct(
        InputOption $inputOption = null,
        array $variants = [50, 100, 300, 1000],
        PaginationControl $pagination = null
    ) {
        $this->inputOption = $inputOption;
        $this->variants = $variants;
        parent::__construct($this->makeDefaultView(), 'page_size_select', 'control_container');
    }

    /**
     * Creates operation.
     *
     * @return OperationInterface
     */
    public function getOperation()
    {
        return new DummyOperation();
    }

    /**
     * @return bool
     */
    public function isManualFormSubmitRequired()
    {
        return true;
    }

    /**
     * @param int[] $variants
     * @return PageSizeSelectControl
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;
        return $this;
    }

    /**
     * Returns variants. Makes array keys equal array values.
     * @return int[]
     */
    public function getVariants()
    {
        return array_combine(array_values($this->variants), array_values($this->variants));
    }

    public function attachToCompound(Compound $root, $prepend = false)
    {
        parent::attachToCompound($root, $prepend);
        // try to update pagination immediately
        // because it can be rendered before this component.
        $this->paginationControl || Utils::applyCallback(function (PaginationControl $pagination) {
            $this->paginationControl || $this->setPaginationControl($pagination);
        }, $root, PaginationControl::class);
    }

    /**
     * @param null|PaginationControl $paginationControl
     * @return PageSizeSelectControl
     */
    public function setPaginationControl(PaginationControl $paginationControl = null)
    {
        $this->paginationControl = $paginationControl;
        $paginationControl && $this->updatePagination();
        return $this;
    }

    private function updatePagination()
    {
        $value = $this->inputOption->getValue();
        if (!$value || $this->paginationControl->getPageSize() == $value) {
            return;
        }
        $this->paginationControl->setPageSize($value);
    }

    /**
     * @return null|PaginationControl
     */
    public function getPaginationControl()
    {
        return $this->paginationControl;
    }

    protected function makeDefaultView()
    {
        return new TemplateView('controls/page_size');
    }


    public function render()
    {
        // try to update pagination one mor time for cases when not configured pagination was used and later configured.
        // (in this case we need to rewrite page_size again)
        $this->paginationControl && $this->updatePagination();
        $this->setViewData();
        return parent::render();
    }

    protected function setViewData()
    {
        $view = $this->getView();
        if (!$view instanceof DataAggregateInterface) {
            return;
        }
        $view->mergeData([
            'inputName' => $this->inputOption->getKey(),
            'selected' => $this->inputOption->getValue(),
            'variants' => $this->getVariants(),
        ]);
    }
}
