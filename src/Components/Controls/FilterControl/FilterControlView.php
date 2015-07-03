<?php

namespace Nayjest\ViewComponents\Components\Controls\FilterControl;

use Nayjest\ViewComponents\Components\Html\Tag;
use Nayjest\ViewComponents\Components\Text;

/**
 * Class FilterControlView
 * @internal
 */
class FilterControlView extends Tag
{
    /**
     * @param string $name
     * @param mixed $value
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