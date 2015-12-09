<?php

namespace Presentation\Framework\Component\ManagedList\Control;

use Nayjest\Tree\Utils;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\CompoundPartInterface;
use Presentation\Framework\Base\CompoundPartTrait;
use Presentation\Framework\Base\ViewAggregate;
use Presentation\Framework\Component\CompoundComponent;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\ManagedList\ManagedList;
use Presentation\Framework\Component\Text;
use Presentation\Framework\Data\Operation\DummyOperation;
use Presentation\Framework\Data\Operation\OperationInterface;
use Presentation\Framework\Initialization\InitializableInterface;
use Presentation\Framework\Initialization\InitializableTrait;
use Presentation\Framework\Input\InputOption;


class PageSizeSelectControl extends ViewAggregate implements
    ControlInterface,
    InitializableInterface,
    CompoundPartInterface
{
    use InitializableTrait {
        InitializableTrait::initialize as private initializeInternal;
    }
    use CompoundPartTrait;

    protected $variants;

    /**
     * @var InputOption
     */
    private $inputOption;

    public function __construct(
        InputOption $inputOption = null,
        array $variants = [50, 100, 300, 1000],
        ComponentInterface $view = null
    )
    {
        $this->inputOption = $inputOption;
        $this->variants = $variants;
        parent::__construct($view);
    }

    /**
     * Creates operation.
     *
     * @return OperationInterface
     */
    public function getOperation()
    {
        return new DummyOperation();
    }

    /**
     * @return bool
     */
    public function isManualFormSubmitRequired()
    {
        return true;
    }

    public function resolveParentName(CompoundComponent $root)
    {
        return 'control_container';
    }

    /**
     * @param int[] $variants
     * @return PageSizeSelectControl
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;
        return $this;
    }

    /**
     * Returns variants. Makes array keys equal array values.
     * @return int[]
     */
    public function getVariants()
    {
        return array_combine(array_values($this->variants),array_values($this->variants));
    }

    public function initialize(ComponentInterface $initializer)
    {
        if (!$initializer instanceof ManagedList) {
            return;
        }
        $this->initializeInternal($initializer);

        $value = $this->inputOption->getValue();
        if (!$value) {
            return;
        }

        $pagination = $this->requireInitializer()->getChildrenRecursive()->findByType(PaginationControl::class);
        /** @var PaginationControl $pagination */
        if ($pagination) {
            $pagination->setPageSize($value);
        } else {
            $callback = function(PaginationControl $pagination) use ($value) {
                $pagination->setPageSize($value);
            };
            Utils::applyCallback($callback, $this->getInitializer(), PaginationControl::class);
        }
    }

    protected function makeDefaultView()
    {
        $currentValue = $this->inputOption->getValue();

        $container = new Text;
        $container->addChildren([
            new Text('&nbsp;'),
            new Tag('label', null, [new Text('Page Size')]),
            new Text('&nbsp;'),
            $select = new Tag('select', ['name' => $this->inputOption->getKey()]),
            new Text('&nbsp;')
        ]);


        foreach($this->getVariants() as $key => $value) {
            $attributes = ['value' => $key];
            if ((int)$currentValue === (int)$key) {
                $attributes['selected'] = 'selected';
            }
            $select->addChild(
                new Tag(
                    'option',
                    $attributes,
                    [new Text($value)]
                )
            );
        }
        return $container;
    }
}