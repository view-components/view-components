<?php
namespace Presentation\Framework\Base;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Rendering\ViewTrait;

abstract class AbstractComponent implements ComponentInterface
{
    use NodeTrait;
    use ViewTrait;
    use ComponentTrait;
}
