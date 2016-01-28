<?php

namespace Presentation\Framework\Service;

/**
 * Class ServiceName contains names(IDs) of presentation framework services inside service container.
 *
 * Usage of this constants instead of raw strings will help to change service names(IDs) easily.
 *
 * Note that further changing of service names(IDs) is possible in case of conflicts with another services inside
 * 3rd-party service container shared to presentation framework
 * (@see \Presentation\Framework\Service\Bootstrap::useContainer())
 */
class ServiceName
{
    const RENDERER = 'pf_renderer';
    const RESOURCE_MANAGER = 'pf_resource_manager';
    const HTML_BUILDER = 'pf_html_builder';
    const CONFIG = 'pf_config';
    const CONFIG_FILE = 'pf_config_file';

    private function __construct()
    {
    }
}
