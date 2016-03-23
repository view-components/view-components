<?php
use ViewComponents\ViewComponents\Customization\CssFrameworks\Bootstrap\ViewHelper;

$useIcons = true;
$helper = new ViewHelper([
    'baseButtonClass' => 'btn',
    'buttonSizeClass' => 'btn-sm',
    'defaultButtonStyleClass' => 'btn-default',

    'baseTableClass' => 'table',
    'tableStyleClass' => 'table-striped table-hover',

    'baseInputClass' => 'form-control',
    'inputSizeClass' => 'input-sm',
]);

return [
    'root' => [
        'js:jquery',
        'js:bootstrap',
        'css:bootstrap'
    ],
    'compound_part#form' => 'add_class:form-inline',
    //'compound_part#submit_button' => [
    'tag&property:type,submit' => [
        'add_class:btn btn-sm btn-success',
        $useIcons ? 'prepend_text:<i class="glyphicon glyphicon-refresh"></i>&nbsp;': []
    ],
    //'tag:button[type=reset]' => 'addClass:btn btn-sm btn-warning',

    'tag:button&property:type,reset' =>
        [
            ['add_class' => 'btn btn-sm btn-warning'],
            $useIcons ? ['prepend_text' => '<i class="glyphicon glyphicon-erase"></i>&nbsp;'] : []
        ],
    'template' => [
        ['override_template' => ['themes/twitter_bootstrap', compact('helper')]]
    ]
];