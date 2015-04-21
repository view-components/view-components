<?php
namespace Nayjest\DataView\Data;

use InvalidArgumentException;
use Nayjest\Builder\ClassUtils;
use Traversable;

/**
 * Class ClassMembersDataAcceptorTrait
 *
 * Implementation of DataAcceptor,
 * that store accepted data array in existing public properties.
 *
 * @implements DataAcceptorInterface
 * @package Nayjest\DataView\Data\DataAcceptorInterface
 */
trait ClassMembersDataAcceptorTrait
{
    /**
     * @param array|Traversable|null $data
     * @return $this
     */
    public function setData($data)
    {
        if ($data === null) {
            return $this;
        } elseif ($data instanceof Traversable) {
            $data = iterator_to_array($data);
        }

        if (!is_array($data)) {
            throw new InvalidArgumentException(
                'setData() method should accept array|Traversable|null'
            );
        }

        ClassUtils::assign($this, $data);
        return $this;
    }
}
