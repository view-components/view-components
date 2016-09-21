<?php
/** 
 * This template renders input with optional label inside container tag('div' by default).
 * All tag attributes can be customized via view variables.
 */
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Component\Html\TagWithText;
use ViewComponents\ViewComponents\Component\TemplateView;

/** @var TemplateView $component */
isset($inline) || ($inline = false);
isset($containerTag) || $containerTag = ($inline ? 'span' : 'div');
isset($inputClass) || $inputClass = '';
isset($containerClass) || $containerClass = '';
isset($labelClass) || $labelClass = '';

isset($name) || $name = '';
isset($value) || $value = '';
isset($inputType) || $inputType = 'text';
isset($placeholder) || $placeholder = isset($label) ? $label : '';
isset($inputAttributes) || $inputAttributes = [];
isset($labelAttributes) || $labelAttributes = [];
isset($containerAttributes) || $containerAttributes = [];

$inputAttributes = array_merge([
    'name' => $name,
    'placeholder' => $placeholder,
    'type' => $inputType,
    'value' => $value,
    'class' => $inputClass
], $inputAttributes);
$containerAttributes = array_merge(['class' => $containerClass], $containerAttributes);
$labelAttributes = array_merge(['class' => $labelClass], $labelAttributes);
?>

<<?= $containerTag ?> <?= Tag::renderAttributes($containerAttributes) ?>>

<?= isset($label) ? new TagWithText('label', $label, $labelAttributes) . '&nbsp;' : '' ?>

<input <?= Tag::renderAttributes($inputAttributes) ?>/>
<?= $component->renderChildren() ?>
</<?= $containerTag ?>>
