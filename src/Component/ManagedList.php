<?php
namespace Presentation\Framework\Component;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Common\ListManager;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Control\ControlInterface;
use Presentation\Framework\Data\ArrayDataProvider;
use Presentation\Framework\Data\DataProviderInterface;
use Presentation\Framework\Base\RepeaterInterface;
use Presentation\Framework\Rendering\ViewTrait;

/**
 * Class ManagedList
 *
 * ManagedList is a component for rendering data lists with interactive controls.
 */
class ManagedList implements ComponentInterface
{
    use NodeTrait;
    use ViewTrait;
    use ComponentTrait;

    public function __construct(
        RepeaterInterface $repeater,
        array $controls = []
    )
    {
        static::manage($repeater, $controls);
        $this->children()->set(
            static::makeComponents($repeater, $controls)
        );
    }

    /**
     * @param ControlInterface[] $controls
     * @return ComponentInterface[]
     */
    protected static function extractViews(array $controls)
    {
        $controlViews = [];
        foreach($controls as $control)
        {
            $controlViews[] = $control->getView();
        }
        return $controlViews;
    }

    /**
     * @param RepeaterInterface $repeater
     * @param ControlInterface[] $controls
     * @return array
     */
    protected static function makeComponents(
        RepeaterInterface $repeater,
        array $controls
    )
    {
        $form = new Tag(
            'form',
            [
                'data-role' => 'controls-form'
            ],
            static::extractViews($controls)
        );
        $form->children()->add(
            new Tag('input', ['type' => 'submit'])
        );
        $itemsContainer = new Tag(
            'div',
            ['data-role' => 'items-container'],
            [$repeater]
        );
        return [$form, $itemsContainer];
    }

    /**
     * Obtains iterator from repeater and replaces it to data provider.
     *
     * @param RepeaterInterface $repeater
     * @return DataProviderInterface
     */
    private static function resolveDataProvider(RepeaterInterface $repeater)
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

    /**
     * @param RepeaterInterface $repeater
     * @param ControlInterface[] $controls
     * @return array
     */
    protected static function manage(RepeaterInterface $repeater, array $controls)
    {
        $manager = new ListManager();
        $manager->manage(static::resolveDataProvider($repeater), $controls);
    }
}
