<?php

namespace ViewComponents\ViewComponents\Service;

/**
 * Class ServiceName contains names(IDs) of presentation framework services inside service container.
 *
 * Usage of this constants instead of raw strings will help to change service names(IDs) easily.
 *
 */
class ServiceName
{
    const RENDERER = 'renderer';
    const RESOURCE_MANAGER = 'resource_manager';
    const HTML_BUILDER = 'html_builder';
    const CONFIG = 'config';
    const CONFIG_FILE = 'config_file';

    private function __construct()
    {
    }
}
