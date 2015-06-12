<?php

namespace Nayjest\ViewComponents\Data\Actions\Base;

use Nayjest\ViewComponents\Data\DataProviderInterface;
use RuntimeException;


class RequiredHandler implements RequiredHandlerInterface
{
    public function checkIsExecuted()
    {
        if ($this->executed === false) {
            throw new RuntimeException('Using event handler that wasn\'t executed');
        }
    }
    protected $executed = false;
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
    ) {
        $this->executed = true;
    }
}