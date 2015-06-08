<?php
namespace Nayjest\ViewComponents\Components\Debug;

use Nayjest\ViewComponents\BaseComponents\AbstractItemView;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class SymfonyVarDump
 *
 * The component displays custom data using Symfony VarDumper.
 *
 */
class SymfonyVarDump extends AbstractItemView
{
    public function render()
    {
        return VarDumper::dump($this->data);
    }
}
