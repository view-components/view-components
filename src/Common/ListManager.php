<?php
namespace Nayjest\ViewComponents\Common;

use Nayjest\ViewComponents\BaseComponents\Controls\ControlInterface2;
use Nayjest\ViewComponents\Data\ArrayDataProvider;
use Nayjest\ViewComponents\Data\DataProviderInterface;
use Nayjest\ViewComponents\Data\RepeaterInterface;

/**
 * Class ListManager
 *
 * Applies operations from controls to repeater iterator.
 */
class ListManager
{
    /**
     * @param RepeaterInterface $repeater
     * @param ControlInterface2[] $controls
     */
    public function manage(RepeaterInterface $repeater, array $controls)
    {
        $provider = $this->resolveDataProvider($repeater);
        foreach ($controls as $control) {
            $provider->operations()->add($control->getOperation());
        }
    }

    /**
     * Obtains iterator from repeater and replaces it to data provider.
     *
     * @param RepeaterInterface $repeater
     * @return DataProviderInterface
     */
    private function resolveDataProvider(RepeaterInterface $repeater)
    {
        $iterator = $repeater->getIterator();
        if ($iterator instanceof DataProviderInterface) {
            $provider = $iterator;
        } else {
            $provider = new ArrayDataProvider($iterator);
            $repeater->setIterator($provider);
        }
        return $provider;
    }
}
