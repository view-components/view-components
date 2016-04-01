<?php
namespace ViewComponents\ViewComponents\Data\Operation;

/**
 * DataProvider operation for sorting rows.
 */
class SortOperation implements OperationInterface
{
    const ASC = 'asc';
    const DESC = 'desc';

    protected $order;

    protected $field;

    /**
     * Creates operation for sorting rows ascending based on values of target field.
     *
     * @param string $field name of data field to sort rows by its value
     * @return SortOperation
     */
    public static function asc($field)
    {
        return new self($field, SortOperation::ASC);
    }

    /**
     *  Creates operation for sorting rows ascending based on values of target field.
     *
     * @param string $field name of data field to sort rows by its value
     * @return SortOperation
     */
    public static function desc($field)
    {
        return new self($field, SortOperation::DESC);
    }

    /**
     * Constructor.
     *
     * @param string|null $field name of data field to sort rows by its value
     * @param string $order (optional, default value: 'asc'),
     *                      please use SortOperation::ASC and SortOperation::DESC constants.
     */
    public function __construct($field = null, $order = SortOperation::ASC)
    {
        $this->setField($field);
        $this->setOrder($order);
    }

    /**
     * Returns sorting order ('asc' or 'desc').
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Sets sorting order.
     *
     * @param string $order 'asc' (ascending) or 'desc' (descending),
     *                      please use SortOperation::ASC and SortOperation::DESC constants.
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Returns name of data field to sort rows by its value.
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Sets name of data field to sort rows by its value.
     *
     * @param string $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
}
