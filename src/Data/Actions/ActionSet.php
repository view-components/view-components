<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.06.2015
 * Time: 18:14
 */

namespace Nayjest\ViewComponents\Data\Actions;


use Nayjest\ViewComponents\Data\Actions\Base\AbstractAction;
use Nayjest\ViewComponents\Data\Actions\Base\ActionInterface;
use Nayjest\ViewComponents\Data\DataProviderInterface;

class ActionSet extends AbstractAction
{
    /** @var ActionInterface[]  */
    protected $actions;

    /**
     * @param ActionInterface[] $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    protected function applyInternal(DataProviderInterface $provider, array $input)
    {
        foreach($this->actions as $action)
        {
            $action->apply($provider, $input);
        }
    }
}
