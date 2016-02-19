<?php

namespace ViewComponents\ViewComponents\Base;

use ViewComponents\ViewComponents\Data\DataAcceptorInterface;

/**
 * Interface of component designed to work with custom data.
 */
interface DataViewComponentInterface extends ViewComponentInterface, DataAcceptorInterface
{
}
