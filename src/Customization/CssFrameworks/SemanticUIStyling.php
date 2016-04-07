<?php

namespace ViewComponents\ViewComponents\Customization\CssFrameworks;

use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Service\ServiceId;

/**
 * Facade class for Semantic UI styling.
 * @see http://semantic-ui.com/
 */
class SemanticUIStyling extends AbstractFrameworkStylingFacade
{
    const STYLING_CONFIG_SERVICE_ID = ServiceId::SEMANTIC_UI_STYLING_CONFIG;
}
