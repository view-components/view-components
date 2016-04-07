
<table>
    <?php
    /** @var TemplateView $component */
    use Stringy\StaticStringy;
    use ViewComponents\ViewComponents\Component\TemplateView;
    foreach($component->getData() as $key => $value): ?>
        <?php
        if (is_object($value) && !method_exists($value, '__toString')) {
            continue;
        }
        ?>
        <tr>
            <td><?= StaticStringy::humanize($key) ?></td>
            <td><?php
                if (is_array($value)) {
                    $view = new TemplateView(
                        $component->getTemplateName(),
                        $value,
                        $component->getRenderer()
                    );
                    echo $view->render();
                } else {
                    echo $value;
                }
                ?></td>
        </tr>
    <?php endforeach ?>
</table>
