<?php
namespace Nayjest\ViewComponents\Data;

/**
 * Interface DataAcceptorInterface
 *
 * Interface describes components, that can accept custom data.
 * @experimental
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
