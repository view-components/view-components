<span data-role = "control-container" data-control="page-size-select">
    <label>Page Size</label>
    <select name="<?= $inputName ?>" class="form-control">
        <?php foreach($variants as $value): ?>
            <option  <?= $selected == $value ? 'selected' : '' ?> value="<?= $value ?>"><?= $value ?></option>
        <?php endforeach ?>
    </select>
</span>