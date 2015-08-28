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

    private $repeater;

    /** @var array|ControlInterface[] $controls */
    private $controls;

    private $isOperationsApplied = false;

    public function __construct(
        RepeaterInterface $repeater,
        array $controls = []
    )
    {
        $this->repeater = $repeater;
        $this->controls = $controls;
    }

    protected function defaultChildren()
    {
        $this->applyOperations();
        return $this->makeComponents();
    }

    /**
     * @return ComponentInterface[]
     */
    private function extractControlViews()
    {
        $controlViews = [];
        foreach($this->controls as $control)
        {
            $controlViews[] = $control->getView();
        }
        return $controlViews;
    }

    private function makeComponents()
    {
        $form = new Tag(
            'form',
            [
                'data-role' => 'controls-form'
            ],
            $this->extractControlViews()
        );
        $form->children()->add(
            new Tag('input', ['type' => 'submit'])
        );
        $itemsContainer = new Tag(
            'div',
            ['data-role' => 'items-container'],
            [$this->repeater]
        );
        return [$form, $itemsContainer];
    }

    /**
     * Obtains iterator from repeater and replaces it to data provider.
     *
     * @return DataProviderInterface
     */
    private function resolveDataProvider()
    {
        $iterator = $this->repeater->getIterator();
        if ($iterator instanceof DataProviderInterface) {
            $provider = $iterator;
        } else {
            $provider = new ArrayDataProvider($iterator);
            $this->repeater->setIterator($provider);
        }
        return $provider;
    }

    public function applyOperations()
    {
        if (!$this->isOperationsApplied) {
            $manager = new ListManager();
            $manager->manage($this->resolveDataProvider(), $this->controls);
            $this->isOperationsApplied = true;
        }
    }
}
