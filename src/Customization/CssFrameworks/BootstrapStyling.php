<?php

namespace ViewComponents\ViewComponents\Customization\CssFrameworks;

use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Service\ServiceId;

/**
 * Facade class for Twitter Bootstrap styling.
 * @see http://getbootstrap.com/
 */
class BootstrapStyling extends AbstractFrameworkStylingFacade
{
    const STYLING_CONFIG_SERVICE_ID = ServiceId::BOOTSTRAP_STYLING_CONFIG;
}
