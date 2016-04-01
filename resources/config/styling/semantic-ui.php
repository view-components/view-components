<?php
$size = 'tiny';
return [
    'root' => [
        'js:jquery',
        'js:semantic-ui',
        'css:semantic-ui',
    ],
    'tag:button' =>
        [
            "add_class:ui medium button",
        ],
    'compound_part#submit_button' =>
        [
            'add_class:primary',
            'prepend_text:<i class="refresh icon"></i>&nbsp;',
            'move_to:control_container',
        ],
    'tag:button&property:type,reset' =>
        [
            'add_class:secondary',
            ['prepend_text' => '<i class="erase icon"></i>&nbsp;']
        ],
    'compound_part#form' => 'add_class:ui form inline fields',
    'compound_part#control_container' => 'add_class: fields inline',
    'template' => [
        ['override_template' => ['themes/semantic-ui', ['size' => $size]]]
    ],
    'tag:table' => 'add_class: ui table celled structured',
];
