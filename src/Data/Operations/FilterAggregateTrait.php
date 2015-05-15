<?php

namespace Nayjest\ViewComponents\Data\Operations;

trait FilterAggregateTrait
{
    /**
     * @return Filter
     */
    abstract protected function getFilterOperation();

    /**
     * @return string
     */
    public function getField()
    {
        return $this->getFilterOperation()->getField();
    }

    /**
     * @param $field
     * @return $this
     */
    public function setField($field)
    {
        $this->getFilterOperation()->setField($field);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->getFilterOperation()->getValue();
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->getFilterOperation()->setValue($value);
        return $this;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->getFilterOperation()->getOperator();
    }

    /**
     * @param $operator
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->getFilterOperation()->setOperator($operator);
        return $this;
    }
}
