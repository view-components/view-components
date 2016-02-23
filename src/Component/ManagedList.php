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

    /**
     * @return ControlInterface[]
     */
    public function getControls()
    {
        return $this->getChildrenRecursive()->filterByType(ControlInterface::class);
    }

//    //
//    //  BEGIN: SETTERS/GETTERS FOR COMPOUND COMPONENTS
//    //
//    /**
//     * @return Repeater|null
//     */
//    public function getRepeater()
//    {
//        return $this->getComponent('repeater');
//    }
//
//    /**
//     * @param RepeaterInterfaceBasic $component
//     * @return $this
//     */
//    public function setRepeater(RepeaterInterfaceBasic $component)
//    {
//        return $this->setComponent('repeater', $component);
//    }
//
//    /**
//     * @return ComponentInterface|null
//     */
    public function getForm()
    {
        return $this->getComponent('form');
    }
//
    public function setForm(ComponentInterface $form)
    {
        return $this->setComponent($form, 'form', 'container');
    }
    protected function setComponent($component, $id = null, $defaultParent = null)
    {
        $part = $component instanceof PartInterface ? $component : new Part($component);

        $id && $part->setId($id);
        !$part->getDestinationParentId() && $defaultParent && $part->setDestinationParentId($defaultParent);
        $this->getComponents()->add($part);
        return $this;
    }

//
//    /**
//     * @return ComponentInterface|null
//     */
    public function getContainer()
    {
        return $this->getComponent('container');
    }
//
//    /**
//     * @param ComponentInterface $component
//     * @return $this
//     */
    public function setContainer(ComponentInterface $component)
    {
        return $this->setComponent($component, 'container', Compound::ROOT_ID);
    }
//
//
//    /**
//     * @return ComponentInterface|null
//     */
    public function getRecordView()
    {
        return $this->getComponent('record_view');
    }
//
//    /**
//     * @param ComponentInterface|null $component
//     * @return $this
//     */
    public function setRecordView(ComponentInterface $component)
    {
        return $this->setComponent($component, 'record_view', 'collection_view');
    }
//
//
//    /**
//     * @return ComponentInterface|null
//     */
//    public function getTitle()
//    {
//
//        return $this->getComponent('title');
//    }
//
//    /**
//     * @param ComponentInterface $component
//     * @return $this
//     */
//    public function setTitle(BasicComponentInterface $component)
//    {
//        return $this->setComponent('title', $component);
//    }
//
//    /**
//     * @return ComponentInterface|null
//     */
    public function getControlContainer()
    {
        return $this->getComponent('control_container');
    }
//
//    /**
//     * @param ComponentInterface $component
//     * @return $this
//     */
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
    //
    //  END: SETTERS/GETTERS FOR COMPOUND COMPONENTS
    //

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
//
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
//
//    public function render()
//    {
//        $this->prepare();
//        return parent::render();
//    }
//
//    /**
//     * @todo why not protected?
//     */
    protected function applyOperations()
    {
        if (!$this->isOperationsApplied) {
            $this->isOperationsApplied = true;
            foreach ($this->getControls() as $control) {
                $this->getDataProvider()->operations()->add($control->getOperation());
            }
        }
    }


//
//    protected function makeDefaultHierarchy()
//    {
//        return [
//            'container' => [
//                'title' => [],
//                'form' => [
//                    'control_container' => [],
//                    'submit_button' => [],
//                ],
//                'list_container' =>
//                    [
//                        'repeater' => [
//                            'record_view' => []
//                        ]
//                    ],
//            ],
//        ];
//    }
//
//    protected function makeDefaultComponents()
//    {
//        return [
//            'container' => new Tag('div', ['data-role' => 'container']),
//            'title' => new Dummy,
//            'form' => new Tag('form'),
//            'control_container' => new Tag('span', ['data-role' => 'control_container']),
//            'submit_button' => (new Tag('input', ['type' => 'submit'])),
//            'list_container' => new Dummy,
//            'repeater' => new Repeater(),
//            'record_view' => new Json(),
//        ];
//    }
//
//    /**
//     * Prepare component for rendering.
//     */
//    protected function prepare()
//    {
//        $this->getTree()->build();
//        $this->applyOperations();
//        $this->getRepeater()->setIterator($this->getDataProvider());
//        $this->hideSubmitButtonIfNotUsed();
//    }

    protected function makeDataInjector()
    {
        $record = $this->getComponent('record_view');
        return function($row) use ($record) {
            $record->setData($row);
        };
    }

    public function render()
    {

        /** @var CollectionView $collection */
        $collection = $this->getComponent('collection_view');
        $collection->setData($this->getDataProvider());
        if ($collection->getDataInjector() === null) {
            $collection->setDataInjector($this->makeDataInjector());
        }
        $this->applyOperations();
        $this->hideSubmitButtonIfNotUsed();
        return parent::render();
    }
}
