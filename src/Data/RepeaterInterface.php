<?php
namespace Nayjest\DataView\Data\DataAcceptorInterface;

use Nayjest\ViewComponents\Rendering\ParentViewInterface;
use Nayjest\ViewComponents\Structure\ParentInterface;
use Traversable;

/**
 * Interface RepeaterInterface
 *
 * Component implementing this interface must
 * set each data row to children DataAcceptorInterface instances
 * and render all ViewInterface instances for each row consequentially.
 *
 * @package Nayjest\DataView\Data\DataAcceptorInterface
 */
interface RepeaterInterface extends ParentViewInterface, ParentInterface
{
    /**
     * Data source to iterate over.
     *
     * @param array|Traversable $source
     */
    public function setDataSource($source);

    /**
     * Renders one row
     *
     * @param $row
     * @return string
     */
    public function renderRow($row);
}
