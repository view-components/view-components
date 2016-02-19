<?php if ($isCurrent): ?>
    <li data-disabled="1">
        <span><?= $title ?></span>
    </li>
<?php else: ?>
    <li>
        <a href="<?= $url ?>"><?= $title ?></a>
    </li>
<?php endif ?>