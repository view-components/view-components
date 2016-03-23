<?php if ($isCurrent): ?>
    <li  class="current">
        <span><?= $title ?></span>
    </li>
<?php else: ?>
    <li>
        <a href="<?= $url ?>"><?= $title ?></a>
    </li>
<?php endif ?>