<?php
namespace Presentation\Framework\Demo;

use Presentation\Framework\Common\InputOption;
use Presentation\Framework\Common\ListManager;
use Presentation\Framework\Components\Container;
use Presentation\Framework\Components\Controls\FilterControl;
use Presentation\Framework\Components\ManagedList;
use Presentation\Framework\Components\Debug\SymfonyVarDump;
use Presentation\Framework\Components\Html\Tag;
use Presentation\Framework\Data\ArrayDataProvider;
use Presentation\Framework\Data\DbTableDataProvider;
use Presentation\Framework\Data\Operations\FilterOperation;
use Presentation\Framework\Data\Operations\SortOperation;
use Presentation\Framework\HtmlBuilder;
use Presentation\Framework\Components\Repeater;
use Presentation\Framework\Components\Text;
use Presentation\Framework\Demo\Components\PersonView;
use Presentation\Framework\Resources\AliasRegistry;
use Presentation\Framework\Resources\IncludedResourcesRegistry;
use Presentation\Framework\Resources\Resources;
use Presentation\Framework\Styling\Bootstrap\BootstrapStyling;
use ReflectionClass;
use ReflectionMethod;

abstract class AbstractController
{
     /**
     * @return \ReflectionMethod[]
     */
    protected function getActions()
    {
        $class = new ReflectionClass($this);
        return $class->getMethods(ReflectionMethod::IS_PUBLIC);

    }

    protected function render($tpl, array $data = [])
    {
        extract($data);
        ob_start();
        $resourcesDir = __DIR__ . '/resources';
        include "$resourcesDir/views/$tpl.php";
        return ob_get_clean();
    }


    protected function renderMenu()
    {
        return $this->render('menu/menu');
    }
}