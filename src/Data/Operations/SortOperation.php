<?php
namespace Presentation\Framework\Data\Operations;


class SortOperation implements OperationInterface
{
    const ASC = 'asc';
    const DESC = 'desc';

    protected $order;

    protected $field;

    public static function asc($field)
    {
        return new self($field, self::ASC);
    }

    public static function desc($field)
    {
        return new self($field, self::DESC);
    }

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