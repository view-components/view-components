<?php
namespace Presentation\Framework\Common;

use Presentation\Framework\Control\ControlInterface;
use Presentation\Framework\Data\DataProviderInterface;

/**
 * Class ListManager
 *
 * Applies operations from controls to repeater iterator.
 */
class ListManager
{
    /**
     * @param DataProviderInterface $dataProvider
     * @param ControlInterface[] $controls
     */
    public function manage(DataProviderInterface $dataProvider, array $controls)
    {

        foreach ($controls as $control) {
            $dataProvider->operations()->add($control->getOperation());
        }
    }
}
