<?php

namespace Presentation\Framework\Component\ManagedList\Control\View;

use Presentation\Framework\Component\Html\Select;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Text;
use Presentation\Framework\Component\ManagedList\Control\SortingSelectControl;

/**
 * Class SortingSelectView
 *
 * @internal
 */
class SortingSelectView extends Tag
{

    /**
     * Constructor.
     *
     * @param SortingSelectControl $control
     */
    public function __construct(SortingSelectControl $control)
    {
        parent::__construct(
            'span',
            [
                'data-role' => 'control-container'
            ],
            [
                new Tag('label', [
                ], [
                    new Text('Sorting')
                ]),
                new Text('&nbsp;'),

                new Select(
                    [
                        'name' => $control->getFieldOption()->getKey(),
                        'id' => $control->getFieldOption()->getKey(),
                    ],
                    $control->getFields(),
                    $control->getFieldOption()->getValue()
                ),
                new Text('&nbsp;'),
                new Select(
                    [
                        'name' => $control->getDirectionOption()->getKey(),
                        'id' => $control->getDirectionOption()->getKey(),
                    ],
                    [
                        'desc' => 'Desc.',
                        'asc' => 'Asc.'
                    ],
                    $control->getDirectionOption()->getValue()
                ),
                new Text('&nbsp;')
            ]
        );
    }
}
