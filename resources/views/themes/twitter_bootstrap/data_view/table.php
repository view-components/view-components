<table class="table table-bordered table-striped">
    <?php
    /** @var TemplateView $component */
    use Stringy\StaticStringy;
    use ViewComponents\ViewComponents\Component\TemplateView;
    foreach($component->getData() as $key => $value): ?>
        <?php
        if (is_object($value) && !method_exists($value, '__toString')) {
            continue;
        }
        if (is_array($value)) {
            $view = new TemplateView(
                $component->getTemplateName(),
                $value,
                $component->getRenderer()
            );
            $valueText = $view->render();

        } else {
            $valueText = $value;
        }

        ?>
        <tr>
            <?php if (is_int($key)): ?>
                <td colspan="2">
                    <?= $valueText ?>
                </td>
            <?php else: ?>
                <td><?= StaticStringy::humanize($key) ?></td>
                <td><?= $valueText ?></td>
            <?php endif ?>

    <?php endforeach ?>
</table>
