<?php
/**
 * Presentation framework configuration.
 *
 */
return [
    /** Will be passed to AliasRegistry constructor. @see AliasRegistry::__construct() **/
    'js_aliases' => [
        'jquery' =>'//code.jquery.com/jquery-2.1.4.min.js',
        'bootstrap' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css',
    ],
    /** Will be passed to AliasRegistry constructor. @see AliasRegistry::__construct() **/
    'css_aliases' => [
        'bootstrap' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css',
    ]
];
