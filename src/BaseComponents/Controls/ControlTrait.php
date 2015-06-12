<?php

namespace Nayjest\ViewComponents\BaseComponents\Controls;

use Nayjest\ViewComponents\Common\InitializedOnceTrait;
use Nayjest\ViewComponents\Common\InputValueReader;
use Nayjest\ViewComponents\Data\Actions\Base\ActionInterface;
use Nayjest\ViewComponents\Data\DataProviderInterface;

trait ControlTrait
{
    /** @var  ActionInterface */
    protected $action;

    public function getAction()
    {
        return $this->action;
    }

}