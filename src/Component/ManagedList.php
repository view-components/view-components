<?php
namespace ViewComponents\ViewComponents\Component;

use Nayjest\Collection\Decorator\ReadonlyObjectCollection;
use Nayjest\Collection\Extended\ObjectCollection;
use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Data\DataAggregateTrait;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\ManagedList\RecordView;
use ViewComponents\ViewComponents\Data\DataProviderInterface;

/**
 * Class ManagedList
 *
 * ManagedList is a component for rendering data lists with interactive controls.
 */
class ManagedList extends Compound implements DataViewComponentInterface
{
    use DataAggregateTrait;

    const CONTAINER_ID = 'container';
    const FORM_ID = 'form';
    const CONTROL_CONTAINER_ID = 'control_container';
    const SUBMIT_BUTTON_ID = 'submit_button';
    const LIST_CONTAINER_ID = 'list_container';
    const COLLECTION_VIEW_ID = 'collection_view';
    const RECORD_VIEW_ID = 'record_view';

    private $isOperationsApplied = false;

    /**
     * ManagedList constructor.
     *
     * @param null $dataProvider
     * @param PartInterface[] $components
     */
    public function __construct($dataProvider = null, $components = [])
    {
        $this->setDataProvider($dataProvider);
        parent::__construct($this->mergeWithDefaultComponents($components));
    }

    /**
     * Returns collection of controls (readonly).
     *
     * @return ControlInterface[]|ReadonlyObjectCollection
     */
    public function getControls()
    {
        return $this->getChildrenRecursive()->filterByType(ControlInterface::class);
    }

    public function getContainer()
    {
        return $this->getComponent(static::CONTAINER_ID);
    }

    public function setContainer(ComponentInterface $component)
    {
        return $this->setComponent($component, static::CONTAINER_ID, static::ROOT_ID);
    }

    public function getForm()
    {
        return $this->getComponent(static::FORM_ID);
    }

    public function setForm(ComponentInterface $form)
    {
        return $this->setComponent($form, static::FORM_ID, static::CONTAINER_ID);
    }

    public function getControlContainer()
    {
        return $this->getComponent(static::CONTROL_CONTAINER_ID);
    }

    public function setControlContainer(ComponentInterface $component)
    {
        return $this->setComponent($component, static::CONTROL_CONTAINER_ID, static::FORM_ID);
    }

    public function getSubmitButton()
    {
        return $this->getComponent(static::SUBMIT_BUTTON_ID);
    }

    public function setSubmitButton(ComponentInterface $component)
    {
        return $this->setComponent($component, static::SUBMIT_BUTTON_ID, static::FORM_ID);
    }

    public function getListContainer()
    {
        return $this->getComponent(static::LIST_CONTAINER_ID);
    }

    public function setListContainer(ComponentInterface $component)
    {
        return $this->setComponent($component, static::LIST_CONTAINER_ID, static::CONTAINER_ID);
    }

    public function getCollectionView()
    {
        return $this->getComponent(static::COLLECTION_VIEW_ID);
    }

    public function setCollectionView(ComponentInterface $component)
    {
        return $this->setComponent($component, static::COLLECTION_VIEW_ID, static::LIST_CONTAINER_ID);
    }

    public function getRecordView()
    {
        return $this->getComponent(static::RECORD_VIEW_ID);
    }

    public function setRecordView(ComponentInterface $component)
    {
        return $this->setComponent($component, static::RECORD_VIEW_ID, static::COLLECTION_VIEW_ID);
    }

    /**
     * Sets data provider.
     *
     * @param DataProviderInterface|null $dataProvider
     * @return $this
     */
    public function setDataProvider(DataProviderInterface $dataProvider = null)
    {
        $this->setData($dataProvider);
        $this->isOperationsApplied = false;
        return $this;
    }

    /**
     * Returns data provider.
     *
     * @return DataProviderInterface|null
     */
    public function getDataProvider()
    {
        return $this->getData();
    }

    /**
     * Renders component and returns output.
     *
     * @return string
     */
    public function render()
    {
        $this->prepare();
        return parent::render();
    }

    /**
     * Prepares component for rendering.
     */
    protected function prepare()
    {
        /** @var CollectionView $collection */
        $collection = $this->getComponent('collection_view');
        $collection->setData($this->getDataProvider());
        if ($collection->getDataInjector() === null) {
            $collection->setDataInjector($this->makeDataInjector());
        }
        $this->applyOperations();
        $this->hideSubmitButtonIfNotUsed();
    }

    /**
     * Hides 'submit_button' component if it's not required by another components.
     */
    protected function hideSubmitButtonIfNotUsed()
    {
        $submit = $this->getComponent(static::SUBMIT_BUTTON_ID);
        if (!$submit) {
            return;
        }
        if (!$this
            ->getChildrenRecursive()
            ->filterByProperty('manual_form_submit_required', true, true)
            ->isEmpty()
        ) {
            return;
        }
        // @todo use correct way hide/detach component
        $submit->parent()->setView(null);
    }

    protected function applyOperations()
    {
        if (!$this->isOperationsApplied) {
            $this->isOperationsApplied = true;
            foreach ($this->getControls() as $control) {
                $this->getDataProvider()->operations()->add($control->getOperation());
            }
        }
    }

    protected function makeDataInjector()
    {
        $record = $this->getComponent('record_view');
        return function ($row) use ($record) {
            $record->mergeData($row);
        };
    }

    /**
     * @param PartInterface[] $components
     * @return array
     */
    protected function mergeWithDefaultComponents($components)
    {
        return (new ObjectCollection($this->makeDefaultComponents()))
            ->addMany($components)
            ->indexByProperty('id');
    }

    /**
     * Creates and returns default compound components.
     *
     * @return PartInterface[]
     */
    protected function makeDefaultComponents()
    {
        return [
            new Part(new Tag('div'), static::CONTAINER_ID, static::ROOT_ID),
            new Part(new Tag('form'), static::FORM_ID, static::CONTAINER_ID),
            new Part(new Tag('span'), static::CONTROL_CONTAINER_ID, static::FORM_ID),
            new Part(new Tag('input', ['type' => 'submit']), static::SUBMIT_BUTTON_ID, static::FORM_ID),
            new Part(new Container(), static::LIST_CONTAINER_ID, static::CONTAINER_ID),
            new Part(new CollectionView(), static::COLLECTION_VIEW_ID, static::LIST_CONTAINER_ID),
            new RecordView(new Json()),
        ];
    }
}
