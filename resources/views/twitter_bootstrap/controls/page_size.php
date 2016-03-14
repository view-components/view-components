<?php
isset($input_class) || $input_class = 'form-control';
?>
<span data-role = "control-container" data-control="page-size-select">
    <label>Page Size</label>
    <select name="<?= $inputName ?>" class="<?= $input_class ?>">
        <?php foreach($variants as $value): ?>
            <option  <?= $selected == $value ? 'selected' : '' ?> value="<?= $value ?>"><?= $value ?></option>
        <?php endforeach ?>
    </select>
</span>