<?php

namespace Presentation\Framework\Control;

use Nayjest\Collection\Extended\ObjectCollection;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Common\ListManager;
use Presentation\Framework\Data\DataProviderInterface;

class ControlCollection extends ObjectCollection
{
    /**
     * Applies operations to data provider.
     *
     * @param DataProviderInterface $dataProvider
     */
    public function applyOperations(DataProviderInterface $dataProvider)
    {
        $manager = new ListManager();
        $manager->manage($dataProvider, $this->toArray());
    }

    /**
     * @return ComponentInterface[]
     */
    public function getViews()
    {
        /** @var ControlInterface $item */
        foreach ($this->items() as $item) {
            yield $item->getView();
        }
    }
}