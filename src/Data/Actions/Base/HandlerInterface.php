<?php

namespace Nayjest\ViewComponents\Data\Actions\Base;

use Nayjest\ViewComponents\Data\DataProviderInterface;

interface HandlerInterface
{
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
    );
}