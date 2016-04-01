<?php

namespace ViewComponents\ViewComponents\Component\ManagedList;

use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Component\Part;

class RecordView extends Part
{
    const ID = 'record_view';

    /**
     * RecordView constructor.
     *
     * @param ViewComponentInterface $view
     */
    public function __construct(ViewComponentInterface $view)
    {
        parent::__construct($view, static::ID, ManagedList::COLLECTION_VIEW_ID);
    }
}
