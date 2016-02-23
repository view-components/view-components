<?php
namespace ViewComponents\ViewComponents\Component;

use Nayjest\Collection\Extended\ObjectCollection;
use ViewComponents\ViewComponents\Base\ComponentInterface;
use ViewComponents\ViewComponents\Base\Compound\PartInterface;
use ViewComponents\ViewComponents\Base\Control\ControlInterface;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Common\HasDataTrait;
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
    use HasDataTrait;

    private $isOperationsApplied = false;

    /**
     * ManagedList constructor.
     * @param null $dataProvider
     * @param PartInterface[] $components
     */
    public function __construct($dataProvider = null, $components = [])
    {
        $this->setDataProvider($dataProvider);
        parent::__construct($this->mergeWithDefaultComponents($components));
    }

    /**
     * @return ControlInterface[]
     */
    public function getControls()
    {
        return $this->getChildrenRecursive()->filterByType(ControlInterface::class);
    }

    public function getContainer()
    {
        return $this->getComponent('container');
    }

    public function setContainer(ComponentInterface $component)
    {
        return $this->setComponent($component, 'container', Compound::ROOT_ID);
    }

    public function getForm()
    {
        return $this->getComponent('form');
    }

    public function setForm(ComponentInterface $form)
    {
        return $this->setComponent($form, 'form', 'container');
    }

    public function getControlContainer()
    {
        return $this->getComponent('control_container');
    }

    public function setControlContainer(ComponentInterface $component)
    {
        return $this->setComponent($component, 'control_container', 'form');
    }

    public function getSubmitButton()
    {
        return $this->getComponent('submit_button');
    }

    public function setSubmitButton(ComponentInterface $component)
    {
        return $this->setComponent($component, 'submit_button', 'form');
    }

    public function getListContainer()
    {
        return $this->getComponent('list_container');
    }

    public function setListContainer(ComponentInterface $component)
    {
        return $this->setComponent($component, 'list_container', 'container');
    }

    public function getCollectionView()
    {
        return $this->getComponent('collection_view');
    }

    public function setCollectionView(ComponentInterface $component)
    {
        return $this->setComponent($component, 'collection_view', 'list_container');
    }

    public function getRecordView()
    {
        return $this->getComponent('record_view');
    }

    public function setRecordView(ComponentInterface $component)
    {
        return $this->setComponent($component, 'record_view', 'collection_view');
    }

    /**
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
     * @return null|DataProviderInterface
     */
    public function getDataProvider()
    {
        return $this->getData();
    }

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

    protected function hideSubmitButtonIfNotUsed()
    {
        $submit = $this->getComponent('submit_button');
        if (!$submit) {
            return;
        }
        if (!$this
            ->getChildrenRecursive()
            ->filterByProperty('manual_form_submit_required', true, true)
            ->isEmpty()) {
            return;
        }
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
        return function($row) use ($record) {
            $record->setData($row);
        };
    }

    protected function setComponent($component, $id = null, $defaultParent = null)
    {
        $part = $component instanceof PartInterface ? $component : new Part($component);

        $id && $part->setId($id);
        !$part->getDestinationParentId() && $defaultParent && $part->setDestinationParentId($defaultParent);
        $this->getComponents()->add($part);
        return $this;
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

    protected function makeDefaultComponents()
    {
        return [
            new Part(new Tag('div'), 'container', 'root'),
            new Part(new Tag('form'), 'form', 'container'),
            new Part(new Tag('span'), 'control_container', 'form'),
            new Part(new Tag('input', ['type' => 'submit']), 'submit_button', 'form'),
            new Part(new Container(), 'list_container', 'container'),
            new Part(new CollectionView(), 'collection_view', 'list_container'),
            new RecordView(new Json()),
        ];
    }
}
