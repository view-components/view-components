<?php

namespace ViewComponents\ViewComponents\Component\ManagedList;

use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Component\Part;

class RecordView extends Part
{
    const ID = 'record_view';
    public function __construct(ViewComponentInterface $view)
    {
        parent::__construct($view, static::ID, 'collection_view');
    }
}
