<?php
namespace Presentation\Framework\Common;

use Presentation\Framework\BaseComponents\Controls\ControlInterface;
use Presentation\Framework\Data\ArrayDataProvider;
use Presentation\Framework\Data\DataProviderInterface;
use Presentation\Framework\Data\RepeaterInterface;

/**
 * Class ListManager
 *
 * Applies operations from controls to repeater iterator.
 */
class ListManager
{
    /**
     * @param RepeaterInterface $repeater
     * @param ControlInterface[] $controls
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
