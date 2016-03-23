<?php if ($isCurrent): ?>
    <a class="item"><?= $title ?></a>
<?php else: ?>

    <a href="<?= $url ?>" class="item"><?= $title ?></a>

<?php endif ?>