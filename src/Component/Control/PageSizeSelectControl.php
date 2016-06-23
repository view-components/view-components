<?php

namespace ViewComponents\ViewComponents\Component\Control;

use Nayjest\Tree\Utils;
use ViewComponents\ViewComponents\Base\Control\AutoSubmittingControlTrait;
use ViewComponents\ViewComponents\Base\Html\AutoSubmittingInputInterface;
use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Component\Compound;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Data\Operation\DummyOperation;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Input\InputOption;

class PageSizeSelectControl extends Part implements ControlInterface, AutoSubmittingInputInterface
{

    use AutoSubmittingControlTrait;

    const ID = 'page_size_select';

    /** @var int[] */
    private $variants;

    /** @var  PaginationControl|null */
    private $paginationControl;

    /**
     * @var InputOption
     */
    private $inputOption;

    /**
     * PageSizeSelectControl constructor.
     *
     * @param InputOption|null $inputOption
     * @param array $variants
     * @param PaginationControl|null $pagination required only in case of usage
     *                                           outside compound component having pagination
     */
    public function __construct(
        InputOption $inputOption = null,
        array $variants = [50, 100, 300, 1000],
        PaginationControl $pagination = null
    ) {
        $this->inputOption = $inputOption;
        $this->variants = $variants;
        parent::__construct($this->makeDefaultView(), static::ID, ManagedList::CONTROL_CONTAINER_ID);
    }

    /**
     * Creates dummy operation.
     *
     * Instead of providing operation to data-provider, this control modifies pagination control.
     *
     * @return OperationInterface
     */
    public function getOperation()
    {
        return new DummyOperation();
    }

    /**
     * Sets page size variants.
     *
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
     *
     * @return int[]
     */
    public function getVariants()
    {
        return array_combine(array_values($this->variants), array_values($this->variants));
    }

    /**
     * @param Compound $root
     * @param bool $prepend
     */
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
     * Sets pagination control affected by page size select control.
     *
     * @param null|PaginationControl $paginationControl
     * @return PageSizeSelectControl
     */
    public function setPaginationControl(PaginationControl $paginationControl = null)
    {
        $this->paginationControl = $paginationControl;
        $paginationControl && $this->updatePagination();
        return $this;
    }

    /**
     * @return null|PaginationControl
     */
    public function getPaginationControl()
    {
        return $this->paginationControl;
    }

    /**
     * Renders component and returns output.
     *
     * @return string
     */
    public function render()
    {
        // try to update pagination one mor time for cases when not configured pagination was used and later configured.
        // (in this case we need to rewrite page_size again)
        $this->paginationControl && $this->updatePagination();
        $this->setViewData();
        return parent::render();
    }

    protected function makeDefaultView()
    {
        return new TemplateView('select');
    }

    protected function setViewData()
    {
        $view = $this->getView();
        if (!$view instanceof TemplateView) {
            return;
        }
        $defaults = [
            'containerAttributes' => [
                'data-role' => 'control-container',
                'data-control' => 'page-size-select',
            ],
            'inline' => true,
            'label' => 'Page Size',
            'options' => $this->getVariants()
        ];
        if ($this->inputOption !== null) {
            $defaults['name'] = $this->inputOption->getKey();
            $defaults['value'] = $this->inputOption->getValue();
        }
        $view->setDefaultData($defaults);
    }

    private function updatePagination()
    {
        $value = $this->inputOption->getValue();
        if (!$value || $this->paginationControl->getPageSize() == $value) {
            return;
        }
        $this->paginationControl->setPageSize($value);
    }
}
