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
        'google_material' => 'https://code.getmdl.io/1.1.1/material.min.js',
    ],
    /** Will be passed to AliasRegistry constructor. @see AliasRegistry::__construct() **/
    'css_aliases' => [
        'bootstrap' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
        'google_material' => 'https://code.getmdl.io/1.1.1/material.min.css',
        'google_material_icons' => 'https://fonts.googleapis.com/icon?family=Material+Icons'
    ]
];
