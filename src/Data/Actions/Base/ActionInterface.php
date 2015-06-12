<?php
namespace Nayjest\ViewComponents\Data\Actions\Base;
use Nayjest\ViewComponents\Data\DataProviderInterface;


/**
 * Interface ActionInterface
 *
 * Actions can accept input and affect on data provider.
 *
 */
interface ActionInterface
{
    public function apply(DataProviderInterface $provider, array $input);

    public function after(callable $callback);
    public function before(callable $callback);
}
