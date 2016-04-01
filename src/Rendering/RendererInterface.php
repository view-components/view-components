<?php

namespace ViewComponents\ViewComponents\Rendering;

interface RendererInterface
{
    /**
     * Renders template and returns output.
     *
     * @param string $template template name
     * @param array $viewData view data
     * @return string
     */
    public function render($template, array $viewData = []);

    /**
     * @return TemplateFinder
     */
    public function getFinder();
}
