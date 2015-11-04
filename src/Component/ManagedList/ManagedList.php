<?php
namespace Presentation\Framework\Component\ManagedList;

use Presentation\Framework\Component\CompoundComponent;
use Presentation\Framework\Component\ManagedList\Control\ControlInterface;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Data\DataProviderInterface;

/**
 * Class ManagedList
 *
 * ManagedList is a component for rendering data lists with interactive controls.
 */
class ManagedList extends CompoundComponent
{
    protected $isOperationsApplied = false;

    /**
     * @var DataProviderInterface|null
     */
    protected $dataProvider;

    /**
     * @param DataProviderInterface|null $dataSrc
     * @param ComponentInterface|null $recordView
     * @param ControlInterface[]|null $controls
     */
    public function __construct(
        $dataSrc = null,
        ComponentInterface $recordView = null,
        $controls = null
    )
    {
        parent::__construct(
            $this->getDefaultTreeConfig()
        );
        $this->setDataProvider($dataSrc);
        if ($recordView) {
            $this->components()->setRecordView($recordView);
        }
        if (!empty($controls)) {
            $this->components()->getForm()->addChildren($controls);
        }
    }

    /**
     * @return Registry|ComponentInterface[]
     */
    public function components()
    {
        return parent::components();
    }

    /**
     * @param DataProviderInterface|null $dataProvider
     * @return $this
     */
    public function setDataProvider(DataProviderInterface $dataProvider = null)
    {
        $this->dataProvider = $dataProvider;
        $this->isOperationsApplied = false;
        return $this;
    }


    /**
     * @return null|DataProviderInterface
     */
    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    public function render()
    {
        $this->updateTreeIfRequired();
        $this->applyOperations();
        return parent::render();
    }

    /**
     * @todo why not protected?
     */
    public function applyOperations()
    {
        $controls = $this->components()->getControls();
        /** @var DataProviderInterface $dataProvider */
        $dataProvider = $this->components()->getRepeater()->getIterator();
        if (!$this->isOperationsApplied) {
            foreach($controls as $control) {
                $dataProvider->operations()->add($control->getOperation());
            }
            $this->isOperationsApplied = true;
        }
    }

    protected function getDefaultTreeConfig()
    {
        return [
            'form' => [
                'submit_button'
            ],
            'container' => [
                'repeater' => [
                    'record_view' => []
                ]
            ]
        ];
    }

    protected function buildTree()
    {
        if ($this->dataProvider !== null) {
            $this->components()->getRepeater()->setIterator($this->dataProvider);
        }
        return parent::buildTree();
    }

    /**
     * Returns new instance of component registry and initializes it with components.
     *
     * @param array $components
     * @return Registry
     */
    protected function makeComponentRegistry(array $components = [])
    {
        return new Registry($components, $this);
    }
}
