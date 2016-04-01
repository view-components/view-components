<?php
namespace ViewComponents\ViewComponents\Component;

use ViewComponents\ViewComponents\Base\Compound\ContainerPartInterface;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Base\Compound\PartTrait;

/**
 * This class is designed to be used with Compound class as a container for compound parts.
 *
 */
class Part extends ViewAggregate implements ContainerPartInterface
{
    use PartTrait;

    /**
     * Constructor.
     *
     * @param ViewComponentInterface|null $view
     * @param string|null $id
     * @param string $destinationParentId
     */
    public function __construct(
        ViewComponentInterface $view = null,
        $id = null,
        $destinationParentId = Compound::ROOT_ID
    ) {
        $this->id = $id;
        $this->destinationParentId = $destinationParentId;
        parent::__construct($view);
    }

    /**
     * Returns container component for inherited compound parts.
     *
     * @return $this|ContainerComponentInterface
     */
    public function getContainer()
    {
        return $this->getView() instanceof ContainerComponentInterface
            ? $this->getView()
            : $this;
    }
}
