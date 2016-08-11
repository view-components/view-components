<?php

namespace ViewComponents\ViewComponents\Component\ManagedList;

use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Component\Part;

class RecordView extends Part
{
    const ID = 'record_view';

    /**
     * RecordView constructor.
     *
     * @param DataViewComponentInterface $view
     */
    public function __construct(DataViewComponentInterface $view)
    {
        parent::__construct($view, static::ID, ManagedList::COLLECTION_VIEW_ID);
    }
}
