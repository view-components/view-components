<?php
/**
 * @var int $total
 * @var int $current
 * @var ViewComponents\ViewComponents\Component\Control\View\PaginationControlView $component
 */

isset($maxLinks) || $maxLinks = 10;
isset($minNumLinksAroundCurrent) || $minNumLinksAroundCurrent = 2;
isset($minNumLinksNearEnd) || $minNumLinksNearEnd = 1;
// without prev & next links
isset($maxNumLinks) || $maxNumLinks = $maxLinks - 2;
if ($component->getLinkTemplateName() === 'controls/pagination/link') {
    $component->setLinkTemplateName('themes/twitter_bootstrap/controls/pagination/link');
}
?>
<nav data-role="control-container" data-control="pagination">
    <ul class="pagination">
        <?= $component->renderLink(1, '«') ?>

        <?php if ($total < $maxNumLinks): ?>
            <?= $component->renderLinksRange(1, $total) ?>
        <?php else: ?>
            <?php if ($current + $minNumLinksAroundCurrent < $maxLinks): ?>
                <?php // 1 separator after current page item ?>
                <?= $component->renderLinksRange(1, $current + $minNumLinksAroundCurrent) ?>
                <li><span>...</span></li>
                <?= $component->renderLinksRange($total - $minNumLinksNearEnd, $total) ?>
            <?php elseif ($total - ($current - $minNumLinksAroundCurrent) < $maxLinks): ?>
                <?php // 1 separator before current page item ?>
                <?= $component->renderLinksRange(1, 1 + $minNumLinksNearEnd) ?>
                <li><span>...</span></li>
                <?= $component->renderLinksRange($current - $minNumLinksAroundCurrent, $total) ?>
            <?php else: ?>
                <?php // 2 separators ?>
                <?= $component->renderLinksRange(1, 1 + $minNumLinksNearEnd) ?>
                <li><span>...</span></li>
                <?= $component->renderLinksRange(
                $current - $minNumLinksAroundCurrent,
                $current + $minNumLinksAroundCurrent
            ) ?>
                <li><span>...</span></li>
                <?= $component->renderLinksRange($total - $minNumLinksNearEnd, $total) ?>
            <?php endif ?>
        <?php endif ?>
        <?= $component->renderLink($total, '»') ?>
    </ul>
</nav>