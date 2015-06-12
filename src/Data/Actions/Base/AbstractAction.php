<?php

namespace Nayjest\ViewComponents\Data\Actions\Base;

use Nayjest\ViewComponents\Common\BeforeAfterTrait;
use Nayjest\ViewComponents\Data\DataProviderInterface;

/**
 * Class AbstractSimpleAction
 *
 * Action based on single input value
 * that provides single operation.
 *
 */
abstract class AbstractAction implements ActionInterface
{
    use BeforeAfterTrait;

    abstract protected function applyInternal(DataProviderInterface $provider, array $input);

    public function apply(DataProviderInterface $provider, array $input)
    {
        if (false === $this->runBeforeCallbacks([$this, $provider, $input])) {
            return;
        }
        $this->applyInternal($provider, $input);
        $this->runAfterCallbacks([$this, $provider, $input]);
    }
}
