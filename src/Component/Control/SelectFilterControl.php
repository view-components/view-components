<?php

namespace ViewComponents\ViewComponents\Component\Control;

use ViewComponents\ViewComponents\Base\Control\AutoSubmittingControlTrait;
use ViewComponents\ViewComponents\Base\Html\AutoSubmittingInputInterface;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputOption;

class SelectFilterControl extends FilterControl implements AutoSubmittingInputInterface
{
    use AutoSubmittingControlTrait;

    protected $selectOptions;

    /**
     * Constructor.
     *
     * @param string $field
     * @param array $options components or 'value' => 'label' array
     * @param InputOption $input
     */
    public function __construct(
        $field,
        array $options = [],
        InputOption $input = null
    ) {
        $this->selectOptions = $options;
        parent::__construct(
            $field,
            FilterOperation::OPERATOR_EQ,
            $input
        );
    }

    protected function makeDefaultView()
    {
        return new TemplateView('select');
    }

    protected function setViewData()
    {
        parent::setViewData();
        /** @var TemplateView $view */
        $view = $this->getView();
        if ($view instanceof TemplateView) {
            $view->setDataItem('options', $this->selectOptions);
        }
    }
}
