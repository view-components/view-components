<?php

namespace ViewComponents\ViewComponents\Service;

/**
 * Class ServiceName contains names(IDs) of presentation framework services inside service container.
 *
 * Usage of this constants instead of raw strings will help to change service names(IDs) easily.
 *
 */
class ServiceId
{
    const RENDERER = 'renderer';
    const TEMPLATE_FINDER = 'template_finder';
    const RESOURCE_MANAGER = 'resource_manager';
    const HTML_BUILDER = 'html_builder';
    const CONFIG = 'config';
    const CONFIG_FILE = 'config_file';
    const BOOTSTRAP_STYLING_CONFIG = 'bootstrap_styling_config';
    const FOUNDATION_STYLING_CONFIG = 'foundation_styling_config';
    const SEMANTIC_UI_STYLING_CONFIG = 'semantic-ui_styling_config';

    private function __construct()
    {
    }
}
