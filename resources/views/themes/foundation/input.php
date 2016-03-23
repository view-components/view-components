<?php
if (!empty($inline)) {
    isset($labelAttributes) || $labelAttributes = [];
    $labelAttributes['style'] = array_key_exists('style', $labelAttributes)
        ? ($labelAttributes['style'] . '; display: inline-block;')
        : 'display:inline-block;';

    isset($inputAttributes) || $inputAttributes = [];
    $inputAttributes['style'] = array_key_exists('style', $inputAttributes)
        ? $inputAttributes['style'] . '; display: inline-block; width:auto;'
        : 'display:inline-block; width: auto;';
}

include __DIR__ . '/../../input.php';