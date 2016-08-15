<?php
namespace ViewComponents\ViewComponents\Component;

use Nayjest\Collection\Decorator\ReadonlyObjectCollection;
use Nayjest\Collection\Extended\ObjectCollection;
use RuntimeException;
use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Component\Html\TagWithText;
use ViewComponents\ViewComponents\Data\ArrayDataAggregateInterface;
use ViewComponents\ViewComponents\Data\DataAggregateInterface;
use ViewComponents\ViewComponents\Data\DataAggregateTrait;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\ManagedList\RecordView;
use ViewComponents\ViewComponents\Data\DataProviderInterface;

/**
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

    /**
     * Returns container component (by default 'div' html tag).
     *
     * @return ContainerComponentInterface|Tag
     */
    public function getContainer()
    {
        return $this->getComponent(static::CONTAINER_ID);
    }

    /**
     * Sets container component.
     *
     * @param ContainerComponentInterface $component
     * @return $this
     */
    public function setContainer(ContainerComponentInterface $component)
    {
        return $this->setComponent($component, static::CONTAINER_ID, static::ROOT_ID);
    }

    /**
     * Returns component that renders form.
     *
     * @return ViewComponentInterface|Tag
     */
    public function getForm()
    {
        return $this->getComponent(static::FORM_ID);
    }

    /**
     * Sets component for rendering form.
     *
     * @param ViewComponentInterface $form
     * @return $this
     */
    public function setForm(ViewComponentInterface $form)
    {
        return $this->setComponent($form, static::FORM_ID, static::CONTAINER_ID);
    }

    /**
     * Returns control container component.
     *
     * @return ContainerComponentInterface
     */
    public function getControlContainer()
    {
        return $this->getComponent(static::CONTROL_CONTAINER_ID);
    }

    public function setControlContainer(ContainerComponentInterface $component)
    {
        return $this->setComponent($component, static::CONTROL_CONTAINER_ID, static::FORM_ID);
    }

    /**
     * Returns submit button component.
     *
     * @return ViewComponentInterface|null
     */
    public function getSubmitButton()
    {
        return $this->getComponent(static::SUBMIT_BUTTON_ID);
    }

    public function setSubmitButton(ViewComponentInterface $component)
    {
        return $this->setComponent($component, static::SUBMIT_BUTTON_ID, static::FORM_ID);
    }

    /**
     * Returns list container component.
     *
     * @return ContainerComponentInterface
     */
    public function getListContainer()
    {
        return $this->getComponent(static::LIST_CONTAINER_ID);
    }

    public function setListContainer(ContainerComponentInterface $component)
    {
        return $this->setComponent($component, static::LIST_CONTAINER_ID, static::CONTAINER_ID);
    }

    /**
     * Returns collection view component.
     *
     * @return CollectionView|ViewComponentInterface|null
     */
    public function getCollectionView()
    {
        return $this->getComponent(static::COLLECTION_VIEW_ID);
    }

    /**
     * Sets collection view component.
     *
     * @param ViewComponentInterface $component
     * @return $this
     */
    public function setCollectionView(ViewComponentInterface $component)
    {
        return $this->setComponent($component, static::COLLECTION_VIEW_ID, static::LIST_CONTAINER_ID);
    }

    /**
     * Returns record view component.
     */
    public function getRecordView()
    {
        return $this->getComponent(static::RECORD_VIEW_ID);
    }

    /**
     * Sets component that will display data record.
     *
     * @param ViewComponentInterface $component
     * @return $this
     */
    public function setRecordView(ViewComponentInterface $component)
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
        /**
         * @see \ViewComponents\ViewComponents\Base\Control\ControlInterface::isManualFormSubmitRequired
         */
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

    /**
     * Applies operations provided by controls to data provider.
     */
    protected function applyOperations()
    {
        if (!$this->isOperationsApplied) {
            $this->isOperationsApplied = true;
            foreach ($this->getControls() as $control) {
                $this->getDataProvider()->operations()->add($control->getOperation());
            }
        }
    }

    /**
     * @return callable
     */
    protected function makeDataInjector()
    {
        /** @var DataViewComponentInterface $record */
        $record = $this->getComponent('record_view');
        return function ($row) use ($record) {
            if ($record instanceof ArrayDataAggregateInterface) {
                $record->mergeData($row);
            } elseif($record instanceof DataAggregateInterface) {
                $data = $record->getData() ?: [];
                if (is_array($data) && is_array($row)) {
                    $record->setData(array_merge($data, $row));
                } else {
                    $record->setData($row);
                }
            } else {
                throw new RuntimeException(
                    'No way to inject data. Default data injector expects that record_view implements DataAggregateInterface.'
                );
            }
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
            static::CONTAINER_ID => new Part(new Tag('div'), static::CONTAINER_ID, static::ROOT_ID),
            static::FORM_ID => new Part(
                new Tag('form', ['data-role' => 'managed_list_form']),
                static::FORM_ID,
                static::CONTAINER_ID
            ),
            static::CONTROL_CONTAINER_ID => new Part(
                new Tag(
                    'span',
                    [   // margin for positioning submit-button
                        // line-height for multi-row appearance
                        'style' => 'margin:4px;line-height:3'
                    ]
                ),
                static::CONTROL_CONTAINER_ID,
                static::FORM_ID
            ),
            static::SUBMIT_BUTTON_ID => new Part(
                new TagWithText(
                    'button',
                    'Filter',
                    ['type' => 'submit', 'data-role' => 'managed_list_submit_button']
                ),
                static::SUBMIT_BUTTON_ID,
                static::FORM_ID
            ),
            static::LIST_CONTAINER_ID => new Part(
                new Container(),
                static::LIST_CONTAINER_ID,
                static::CONTAINER_ID
            ),
            static::COLLECTION_VIEW_ID => new Part(
                new CollectionView(),
                static::COLLECTION_VIEW_ID,
                static::LIST_CONTAINER_ID
            ),
            static::RECORD_VIEW_ID => new RecordView(new Json()),
        ];
    }
}
