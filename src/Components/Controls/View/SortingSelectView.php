<?php

namespace Presentation\Framework\Components\Controls\View;

use Presentation\Framework\Components\Controls\SortingSelectControl;
use Presentation\Framework\Components\Html\Select;
use Presentation\Framework\Components\Html\Tag;
use Presentation\Framework\Components\Text;

/**
 * Class FilterControlView
 * @internal
 */
class SortingSelectView extends Tag
{

    /**
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