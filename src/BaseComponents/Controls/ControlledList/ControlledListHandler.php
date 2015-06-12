<?php
namespace Nayjest\ViewComponents\BaseComponents\Controls\ControlledList;

use Nayjest\ViewComponents\Data\Actions\Base\ActionInterface;
use Nayjest\ViewComponents\Data\Actions\Base\HandlerInterface;
use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\Data\RepeaterInterface;

class ControlledListHandler implements HandlerInterface
{

    protected $repeater;

    public function __construct(RepeaterInterface $repeater)
    {
        $this->repeater = $repeater;
    }
    /**
     * @param ActionInterface $action
     * @param DataProviderInterface $dataProvider
     * @param array $input
     * @return bool|null execution will be canceled if false was returned
     */
    public function __invoke(
        ActionInterface $action,
        DataProviderInterface $dataProvider,
        array $input
    )
    {
        $this->repeater->setIterator($dataProvider);
    }
}
