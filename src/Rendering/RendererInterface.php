<?php

namespace ViewComponents\ViewComponents\Rendering;

interface RendererInterface
{
    /**
     * Renders template and returns output.
     *
     * @param string $template template name
     * @param array $viewData
     * @return string
     */
    public function render($template, array $viewData = []);
}
