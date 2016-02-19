<?php

namespace ViewComponents\ViewComponents\Component\ManagedList;

use ViewComponents\ViewComponents\Component\CompoundPart;
use ViewComponents\ViewComponents\Base\ViewComponentInterface;

class RecordView extends CompoundPart
{
    const ID = 'record_view';
    public function __construct(ViewComponentInterface $view)
    {
        parent::__construct($view, static::ID, 'collection_view');
    }
}
