<?php if ($isCurrent): ?>
    <li data-disabled="1" <?= is_numeric($title)?'class="active"' : '' ?>>
        <span><?= $title ?></span>
    </li>
<?php else: ?>
    <li>
        <a href="<?= $url ?>"><?= $title ?></a>
    </li>
<?php endif ?>