<?php

namespace ViewComponents\ViewComponents\Rendering;


interface RendererInterface
{
    /**
     * @param string $template
     * @param array $viewData
     * @return string
     */
    public function render($template, array $viewData = []);
}