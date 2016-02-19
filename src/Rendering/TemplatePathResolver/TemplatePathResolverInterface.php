<?php

namespace ViewComponents\ViewComponents\Rendering\TemplatePathResolver;

interface TemplatePathResolverInterface
{
    public function registerPath($path, $namePrefix = '', $highPriority = false);
}