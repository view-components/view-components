<?php
use ViewComponents\ViewComponents\Data\Operation\SortOperation;
/**
 * @var string $selectedDirection
 * @var string $selectedField
 * @var string $fieldSelectName
 * @var string $directionSelectName
 * @var string[] $fields
 */

isset($input_class) || $input_class = 'form-control';
?>
<span data-role = "control-container" data-control="sorting-select">
    <label>Sorting</label>
    <select name="<?= $fieldSelectName ?>" class="<?= $input_class ?>">
        <?php foreach($fields as $value => $label): ?>
            <option  <?= $selectedField == $value ? 'selected' : '' ?> value="<?= $value ?>"><?= $label ?></option>
        <?php endforeach ?>
    </select>
    <select name="<?= $directionSelectName ?>" class="<?= $input_class ?>">
            <option <?= $selectedDirection == SortOperation::ASC ? 'selected ':'' ?> value="asc">Asc.</option>
            <option <?= $selectedDirection == SortOperation::DESC ? 'selected ':'' ?> value="desc">Desc.</option>
    </select>
</span>