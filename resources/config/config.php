<?php
/**
 * Presentation framework configuration.
 *
 */
return [
    /** Will be passed to AliasRegistry constructor. @see AliasRegistry::__construct() **/
    'js_aliases' => [
        'jquery' =>'//code.jquery.com/jquery-2.2.1.min.js',
        'bootstrap' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js',
        'foundation' => 'https://cdn.jsdelivr.net/foundation/6.2.0/foundation.min.js',
        'semantic-ui' => 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.js',
        'bootstrap-datepicker' => 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js',
    ],
    /** Will be passed to AliasRegistry constructor. @see AliasRegistry::__construct() **/
    'css_aliases' => [
        'bootstrap' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
        'foundation' => 'https://cdn.jsdelivr.net/foundation/6.2.0/foundation.min.css',
        'semantic-ui' => 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.css',
        'bootstrap-datepicker' => 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.min.css',
    ]
];
