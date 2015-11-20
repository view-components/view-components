<?php
namespace Presentation\Framework\Component\ManagedList;

use Presentation\Framework\Base\RepeaterInterface;
use Presentation\Framework\Component\CompoundComponent;
use Presentation\Framework\Component\Dummy;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Json;
use Presentation\Framework\Component\ManagedList\Control\ControlInterface;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Component\Repeater;
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
     * @param DataProviderInterface|null $dataProvider
     * @param ComponentInterface|null $recordView
     * @param ComponentInterface[] l $components
     */
    public function __construct(
        $dataProvider = null,
        ComponentInterface $recordView = null,
        array $components = []
    )
    {
        parent::__construct(
            $this->makeDefaultHierarchy(),
            $this->makeDefaultComponents()
        );
        $this->setDataProvider($dataProvider);
        if (count($components)) {
            $this->children()->addMany($components);
        }
        if ($recordView) {
            $this->setRecordView($recordView);
        }
    }

    /**
     * @return ControlInterface[]
     */
    public function getControls()
    {
        return $this->getChildrenRecursive()->filterByType(ControlInterface::class);
    }

    //
    //  BEGIN: SETTERS/GETTERS FOR COMPOUND COMPONENTS
    //
    /**
     * @return Repeater|null
     */
    public function getRepeater()
    {
        return $this->getComponent('repeater');
    }

    /**
     * @param RepeaterInterface $component
     * @return $this
     */
    public function setRepeater(RepeaterInterface $component)
    {
        return $this->setComponent('repeater', $component);
    }

    /**
     * @return ComponentInterface|null
     */
    public function getForm()
    {
        return $this->getComponent('form');
    }

    public function setForm(ComponentInterface $form)
    {
        return $this->setComponent('form', $form);
    }

    /**
     * @return ComponentInterface|null
     */
    public function getContainer()
    {
        return $this->getComponent('container');
    }

    /**
     * @param ComponentInterface $component
     * @return $this
     */
    public function setContainer(ComponentInterface $component)
    {
        return $this->setComponent('container', $component);
    }


    /**
     * @return ComponentInterface|null
     */
    public function getRecordView()
    {

        return $this->getComponent('record_view');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setRecordView(ComponentInterface $component)
    {
        return $this->setComponent('record_view', $component);
    }


    /**
     * @return ComponentInterface|null
     */
    public function getTitle()
    {

        return $this->getComponent('title');
    }

    /**
     * @param ComponentInterface $component
     * @return $this
     */
    public function setTitle(ComponentInterface $component)
    {
        return $this->setComponent('title', $component);
    }


    /**
     * @return ComponentInterface|null
     */
    public function getSubmitButton()
    {
        return $this->tree->get('submit_button');
    }

    /**
     * @param ComponentInterface|null $component
     * @return $this
     */
    public function setSubmitButton(ComponentInterface $component)
    {
        return $this->setComponent('submit_button', $component);
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

    protected function hideSubmitButtonIfNotUsed()
    {
        $submit = $this->getSubmitButton();

        if (
            $submit
            && $this
                ->getChildrenRecursive()
                ->filterByProperty('manual_form_submit_required', true, true)
                ->isEmpty()
        )
        {
            $submit->hide();
        }

    }

    public function render()
    {
        $this->tree->build();
        $this->applyOperations();
        $this->getRepeater()->setIterator($this->getDataProvider());
        $this->hideSubmitButtonIfNotUsed();
        return parent::render();
    }

    /**
     * @todo why not protected?
     */
    public function applyOperations()
    {
        if (!$this->isOperationsApplied) {
            foreach ($this->getControls() as $control) {
                $this->getDataProvider()->operations()->add($control->getOperation());
            }
            $this->isOperationsApplied = true;
        }
    }

    protected function makeDefaultHierarchy()
    {
        return [
            'container' => [
                'title' => [],
                'form' => [
                    'control_container' => [],
                    'submit_button' => [],
                ],
                'list_container' =>
                    [
                        'repeater' => [
                            'record_view' => []
                        ]
                    ],
            ],
        ];
    }

    protected function makeDefaultComponents()
    {
        return [
            'container' => new Tag('div', ['data-role' => 'container']),
            'title' => new Dummy,
            'form' => new Tag('form'),
            'control_container' => new Tag('span', ['data-role' => 'control_container']),
            'submit_button' => (new Tag('input', ['type' => 'submit'])),
            'list_container' => new Dummy,
            'repeater' => new Repeater(),
            'record_view' => new Json(),
        ];
    }
}
