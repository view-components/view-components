<?php
use ViewComponents\ViewComponents\Data\Operation\SortOperation;
/**
 * @var string $selectedDirection
 * @var string $selectedField
 * @var string $fieldSelectName
 * @var string $directionSelectName
 * @var string[] $fields
 */
?>
<span data-role = "control-container" data-control="sorting-select">
    <label>Sorting</label>
    <select name="<?= $fieldSelectName ?>">
        <?php foreach($fields as $value => $label): ?>
            <option  <?= $selectedField == $value ? 'selected' : '' ?> value="<?= $value ?>"><?= $label ?></option>
        <?php endforeach ?>
    </select>
    <select name="<?= $directionSelectName ?>">
            <option <?= $selectedDirection == SortOperation::ASC ? 'selected ':'' ?> value="asc">Asc.</option>
            <option <?= $selectedDirection == SortOperation::DESC ? 'selected ':'' ?> value="desc">Desc.</option>
    </select>
</span>