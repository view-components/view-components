<?php
namespace Nayjest\ViewComponents\Data;

/**
 * Interface DataAcceptorInterface
 *
 * Interface describes components, that can accept custom data.
 *
 * @package Nayjest\DataView\Data
 */
interface DataAcceptorInterface
{
    /**
     * Sets custom data.
     *
     * @param $data
     * @return $this
     */
    public function setData($data);
}
