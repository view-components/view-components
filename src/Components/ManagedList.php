<?php
namespace Nayjest\ViewComponents\Components;

use Nayjest\ViewComponents\BaseComponents\ContainerInterface;
use Nayjest\ViewComponents\BaseComponents\ContainerTrait;
use Nayjest\ViewComponents\BaseComponents\Controls\ControlInterface;
use Nayjest\ViewComponents\Common\ListManager;
use Nayjest\ViewComponents\Components\Html\Tag;
use Nayjest\ViewComponents\Data\RepeaterInterface;

class ManagedList implements
    ContainerInterface
{
    use ContainerTrait;

    public function __construct(
        RepeaterInterface $repeater,
        array $controls = []
    )
    {
        $this->manage($repeater, $controls);
        $this->components()->set(
            $this->makeComponents($repeater, $controls)
        );
    }

    public function render()
    {
        return $this->renderAllComponents();
    }

    /**
     * @param RepeaterInterface $repeater
     * @param ControlInterface[] $controls
     * @return array
     */
    protected function makeComponents(
        RepeaterInterface $repeater,
        array $controls
    )
    {
        $form = new Tag(
            'form',
            [
                'data-role' => 'controls-form'
            ],
            $controls
        );
        $form->components()->add(
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
     * @param RepeaterInterface $repeater
     * @param ControlInterface[] $controls
     * @return array
     */
    protected function manage(RepeaterInterface $repeater, array $controls)
    {
        $manager = new ListManager();
        $manager->manage($repeater, $controls);
    }
}
