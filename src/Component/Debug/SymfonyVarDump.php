<?php
namespace Presentation\Framework\Component\Debug;

use Presentation\Framework\Base\AbstractDataView;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

/**
 * Class SymfonyVarDump
 *
 * The component displays custom data using Symfony VarDumper.
 *
 */
class SymfonyVarDump extends AbstractDataView
{
    public function renderData()
    {
        $cloner = new VarCloner();
        $dumper = ('cli' === PHP_SAPI ? new CliDumper : new HtmlDumper);
        $output = fopen('php://memory', 'r+b');
        $dumper->dump($cloner->cloneVar($this->data), $output);
        return stream_get_contents($output, -1, 0);
    }
}
