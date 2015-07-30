<?php

namespace Presentation\Framework\Component\ControlView;

use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Text;

/**
 * Class FilterControlView
 *
 * @internal
 */
class FilterControlView extends Tag
{
    /**
     * Constructor.
     *
     * @param string $name
     * @param string|null $value
     * @param string|null $label
     */
    public function __construct($name, $value = null, $label = null)
    {
        $id = $name;
        parent::__construct(
            'span',
            [
                'data-role' => 'control-container'
            ],
            [
                new Tag('label', [
                    'for' => $id
                ], [
                    new Text($label)
                ]),
                new Text('&nbsp;'),
                new Tag('input', [
                    'value' => $value,
                    'type' => 'text',
                    'name' => $name,
                    'id' => $id
                ]),
                new Text('&nbsp;')
            ]
        );
    }
}
