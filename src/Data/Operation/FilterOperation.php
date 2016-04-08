<?php
namespace ViewComponents\ViewComponents\Data\Operation;

/**
 * DataProvider operation for filtering rows.
 */
class FilterOperation implements OperationInterface
{
    const OPERATOR_LIKE = 'like';
    const OPERATOR_STR_STARTS_WITH = 'str_starts_with';
    const OPERATOR_STR_ENDS_WITH = 'str_ends_with';
    const OPERATOR_STR_CONTAINS = 'str_contains';
    const OPERATOR_EQ = '=';
    const OPERATOR_NOT_EQ = '<>';
    const OPERATOR_GT = '>';
    const OPERATOR_LT = '<';
    const OPERATOR_LTE = '<=';
    const OPERATOR_GTE = '>=';

    protected $field;

    protected $value;

    protected $operator;

    /**
     * Constructor.
     *
     * @param string|null $field name of data field to filter rows by its value
     * @param string|null $operator
     * @param mixed $value
     */
    public function __construct(
        $field = null,
        $operator = self::OPERATOR_EQ,
        $value = null
    ) {
        $this->setField($field);
        $this->setValue($value);
        $this->setOperator($operator);
    }

    /**
     * Returns name of data field to filter rows by its value.
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Sets name of data field to filter rows by its value.
     *
     * @param $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param $operator
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
        return $this;
    }
}
