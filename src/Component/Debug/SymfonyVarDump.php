<?php
namespace ViewComponents\ViewComponents\Component\Debug;

use Nayjest\Tree\ChildNodeTrait;
use ViewComponents\ViewComponents\Base\DataViewComponentInterface;
use ViewComponents\ViewComponents\Common\HasDataTrait;
use ViewComponents\ViewComponents\Rendering\ViewTrait;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

/**
 * Class SymfonyVarDump
 *
 * The component displays custom data using Symfony VarDumper.
 *
 */
class SymfonyVarDump implements DataViewComponentInterface
{
    use ChildNodeTrait;
    use ViewTrait;
    use HasDataTrait;

    /**
     * Constructor.
     *
     * @param mixed $data data to render
     */
    public function __construct($data)
    {
        $this->setData($data);
    }

    /**
     * Renders data.
     *
     * @return string
     */
    public function render()
    {
        $cloner = new VarCloner();
        $dumper = ('cli' === PHP_SAPI ? new CliDumper : new HtmlDumper);
        $output = fopen('php://memory', 'r+b');
        $dumper->dump($cloner->cloneVar($this->getData()), $output);
        return stream_get_contents($output, -1, 0);
    }
}
