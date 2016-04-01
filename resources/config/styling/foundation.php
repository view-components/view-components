<?php
$size = '';
return [
    'root' => [
        'js:jquery',
        'js:foundation',
        'css:foundation'
    ],
    'tag:table' => 'add_class:stack hover',
    //'compound_part#form' => 'add_class:form-inline',
    'tag:button' =>
        [
            "add_class:$size button",
            ['set_attribute' =>  ['style','position:relative; top:7px']]
        ],
    'compound_part#submit_button' => 'add_class:success',
    'tag:button&property:type,reset' => 'add_class:warning',
    'template' => [
        ['override_template' => ['themes/foundation']]
    ]
];
