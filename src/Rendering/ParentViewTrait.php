<?php
namespace Nayjest\ViewComponents\Rendering;

trait ParentViewTrait
{
    /**
     * Returns child components.
     *
     * @return \Nayjest\ViewComponents\Structure\Collection
     */
    abstract public function components();

    public function renderComponents($section = null)
    {
        $components = $this
            ->components()
            ->findAllBySection($section);
        $output = '';
        foreach ($components as $component) {
            if ($component instanceof ViewInterface) {
                $output .= $component->render();
            }
        }
        return $output;
    }
}
