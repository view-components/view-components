<?php
namespace Nayjest\ViewComponents\Demo;

use Nayjest\ViewComponents\Components\Container;
use Nayjest\ViewComponents\Components\ControlledList;
use Nayjest\ViewComponents\Components\Controls\Filter;
use Nayjest\ViewComponents\Components\Debug\SymfonyVarDump;
use Nayjest\ViewComponents\Components\Debug\VarExport;
use Nayjest\ViewComponents\Components\Html\Tag;
use Nayjest\ViewComponents\Data\ArrayDataProvider;
use Nayjest\ViewComponents\Data\DbTableDataProvider;
use Nayjest\ViewComponents\Data\Operations\Sorting;
use Nayjest\ViewComponents\HtmlBuilder;
use Nayjest\ViewComponents\Components\Repeater;
use Nayjest\ViewComponents\Components\Text;
use Nayjest\ViewComponents\Demo\Components\PersonView;
use Nayjest\ViewComponents\Resources\AliasRegistry;
use Nayjest\ViewComponents\Resources\IncludedResourcesRegistry;
use Nayjest\ViewComponents\Resources\Resources;
use PDO;
use ReflectionClass;
use ReflectionMethod;

class Controller
{
    protected function getUsersData()
    {
        return include(dirname(__DIR__).'/fixtures/users.php');
    }

    protected function getDataProvider($operations = [])
    {
        return (isset($_GET['use-db']) && $_GET['use-db'])
            ? new DbTableDataProvider(
                db_connection(),
                'users',
                $operations
            )
            : new ArrayDataProvider(
                $this->getUsersData(),
                $operations
            );
    }

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

    public function index()
    {
        $out = '';
        $out .= $this->renderMenu();
        $out .= '<h1>Nayjest/ViewComponents test app</h1><h2>Index Page</h2>';

        return $out;
    }

    /**
     * Basic usage of Repeater component.
     *
     * @return string
     */
    public function demo1()
    {
        $data = $this->getUsersData();
        $view = new Container([
            new Text('<h1>Users List</h1>'),
            new Repeater($data, [new PersonView])
        ]);
        return $this->renderMenu() . $view->render();
    }

    /**
     * Demo1 extended by HtmlBuilder usage.
     *
     * @return string
     */
    public function demo2()
    {
        $html = new HtmlBuilder(new Resources(new AliasRegistry(), new AliasRegistry(), new IncludedResourcesRegistry()));
        $data = $this->getUsersData();
        $view = new Container([
            $html->h1('Users List'),
            $html->hr(),
            new Repeater($data, [new PersonView]),
            $html->hr(),
            $html->div('Footer')
        ]);
        return $this->renderMenu() . $view->render();
    }

    /**
     * Array Data Provider with sorting.
     *
     * @return string
     */
    public function demo3()
    {
        $data = $this->getUsersData();

        $view = new Container([
            new Text('<h1>Users List</h1>'),
            new Repeater(
                new ArrayDataProvider(
                    $data,
                    [new Sorting('name')]
                ),
                [new PersonView])
        ]);
        return $this->renderMenu() . $view->render();
    }

    /**
     * Filtering controls.
     *
     * @return string
     */
    public function demo4()
    {
        $provider = $this->getDataProvider([Sorting::asc('name')]);

        $view = new Container([
            new Tag('form', null, [
                $filter = new Filter('name'),
                new Tag('button', ['type' => 'submit'], [
                    new Text('Filter')
                ]),
            ]),
            new Text('<h1>Users List</h1>'),
            new Repeater(
                $provider,
                [new PersonView])
        ]);
        $filter->initialize($provider, $_GET);
        return $this->renderMenu() . $view->render();
    }

    /**
     * ControlledList
     *
     * @return string
     */
    public function demo5()
    {
        $provider = $this->getDataProvider();
        $list = new ControlledList(new SymfonyVarDump, [
            new Filter('name'),
            new Filter('role')
        ]);

        $list->initialize($provider, $_GET);
        return $this->renderMenu() . $list->render();
    }

}