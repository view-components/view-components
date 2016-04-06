<?php
$inputClass = $helper->getInputClasses()
    . (isset($inputClass) ? " $inputClass" : '');
include __DIR__ . '/../../input.php';