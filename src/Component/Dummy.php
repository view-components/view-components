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
}
