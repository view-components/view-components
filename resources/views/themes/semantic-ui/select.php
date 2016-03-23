<?php
// use DIV for inline too
isset($containerTag) || $containerTag = 'div';

// add 'field' class
isset($containerClass) || $containerClass = '';
$containerClass .=  ' field';

include __DIR__ . '/../../select.php';