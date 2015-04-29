<?php
namespace Nayjest\ViewComponents\Data\Operations;


class Sorting implements OperationInterface
{
    const ASC = 'asc';
    const DESC = 'desc';

    protected $order;

    protected $field;

    public function __construct($field = null, $order = self::ASC)
    {
        $this->setField($field);
        $this->setOrder($order);
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $order asc or desc
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
}