<?php

namespace Nayjest\ViewComponents\Data\Actions\Base;

interface RequiredHandlerInterface extends HandlerInterface
{
    public function checkIsExecuted();
}