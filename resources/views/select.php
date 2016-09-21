<?php
use ViewComponents\ViewComponents\Component\Html\Select;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\Html\TagWithText;
use ViewComponents\ViewComponents\Component\TemplateView;

/** @var TemplateView $component */
isset($inline) || ($inline = false);
isset($containerTag) || $containerTag = ($inline ? 'span' : 'div');
isset($inputClass) || $inputClass = '';
isset($containerClass) || $containerClass = '';
isset($labelClass) || $labelClass = '';

isset($options) || $options = [];
isset($name) || $name = '';
isset($value) || $value = '';
isset($inputType) || $inputType = 'text';
isset($inputAttributes) || $inputAttributes = [];
isset($labelAttributes) || $labelAttributes = [];
isset($containerAttributes) || $containerAttributes = [];

$inputAttributes = array_merge([
    'name' => $name,
    'type' => $inputType,
    'class' => $inputClass
], $inputAttributes);
$containerAttributes = array_merge(['class' => $containerClass], $containerAttributes);
$labelAttributes = array_merge(['class' => $labelClass], $labelAttributes);

// support of auto-submitting form on value change
if (isset($autoSubmit) && $autoSubmit === true) {
    if (array_key_exists('onchange', $inputAttributes)) {
        $inputAttributes['onchange'] .= ';this.form.submit();';
    } else {
        $inputAttributes['onchange'] = 'this.form.submit()';
    }
}
?>

<<?= $containerTag ?> <?= Tag::renderAttributes($containerAttributes) ?>>

<?= isset($label) ? new TagWithText('label', $label, $labelAttributes): '' ?>

<?= new Select($inputAttributes, $options, $value) ?>
</<?= $containerTag ?>>
