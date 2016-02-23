<?php
namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\Compound\ContainerPartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Base\Compound\PartTrait;

/**
 * Class Part represents custom compound part that is a view aggregate and container.
 *
 */
class Part extends ViewAggregate implements ContainerPartInterface
{
    use PartTrait;

    public function __construct(
        ViewComponentInterface $view = null,
        $id = null,
        $destinationParentId = Compound::ROOT_ID
    )
    {
        $this->id = $id;
        $this->destinationParentId = $destinationParentId;
        parent::__construct($view);
    }

    /**
     * @return $this|ContainerComponentInterface
     */
    public function getContainer()
    {
        return $this->getView() instanceof ContainerComponentInterface
            ? $this->getView()
            : $this;
    }
}
