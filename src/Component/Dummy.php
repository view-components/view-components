<?php
namespace Presentation\Framework\Component;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Rendering\ViewTrait;

class Dummy implements ComponentInterface
{
    use NodeTrait;
    use ViewTrait;
    use ComponentTrait;

    private static $instance;

    /**
     * Returns shared instance of dummy component.
     *
     * @return Dummy
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
