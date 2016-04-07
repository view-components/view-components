<?php

namespace ViewComponents\ViewComponents\Customization\CssFrameworks;

use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Service\ServiceId;

/**
 * Facade class for Foundation styling.
 * @see http://foundation.zurb.com/
 */
class FoundationStyling extends AbstractFrameworkStylingFacade
{
    const STYLING_CONFIG_SERVICE_ID = ServiceId::FOUNDATION_STYLING_CONFIG;
}
