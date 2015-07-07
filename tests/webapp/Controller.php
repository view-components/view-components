<?php
namespace Presentation\Framework\Demo;

use Presentation\Framework\Common\InputValueReader;
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

class Controller
{
    protected function getUsersData()
    {
        return include(dirname(__DIR__) . '/fixtures/users.php');
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
                    [new SortOperation('name')]
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
        $provider = $this->getDataProvider([SortOperation::asc('name')]);

        $filter1 = new FilterControl(
            'name',
            FilterOperation::OPERATOR_EQ,
            new InputValueReader('name_filter', $_GET)
        );
        $filter2 = new FilterControl(
            'role',
            FilterOperation::OPERATOR_EQ,
            new InputValueReader('role_filter', $_GET)
        );

        $view = new Container([
            new Tag('form', null, [
                $filter1,
                $filter2,
                new Tag('button', ['type' => 'submit'], [
                    new Text('Filter')
                ]),
            ]),
            new Text('<h1>Users List</h1>'),
            new Repeater(
                $provider,
                [new PersonView])
        ]);

        $provider->operations()->add($filter1->getOperation());
        $provider->operations()->add($filter2->getOperation());

        return $this->renderMenu() . $view->render();
    }


    /**
     * Filtering controls + ListManager
     *
     * @return string
     */
    public function demo4_1()
    {
        $provider = $this->getDataProvider([SortOperation::asc('name')]);

        $filter1 = new FilterControl(
            'name',
            FilterOperation::OPERATOR_EQ,
            new InputValueReader('name_filter', $_GET)
        );
        $filter2 = new FilterControl(
            'role',
            FilterOperation::OPERATOR_EQ,
            new InputValueReader('role_filter', $_GET)
        );

        $view = new Container([
            new Tag('form', null, [
                $filter1,
                $filter2,
                new Tag('button', ['type' => 'submit'], [
                    new Text('Filter')
                ]),
            ]),
            new Text('<h1>Users List</h1>'),
            $repeater = new Repeater(
                $provider,
                [new PersonView])
        ]);

        $manager = new ListManager();
        $manager->manage($repeater, [$filter1, $filter2]);

        return $this->renderMenu() . $view->render();
    }

    /**
     * Filtering controls in managed list
     *
     * @return string
     */
    public function demo4_2()
    {
        $provider = $this->getDataProvider();
        $list = new ManagedList(
            new Repeater(
                $provider,
                [new SymfonyVarDump]
            ),
            [
                new FilterControl(
                    'name',
                    FilterOperation::OPERATOR_EQ,
                    new InputValueReader('name_filter', $_GET)
                ),
                new FilterControl(
                    'role',
                    FilterOperation::OPERATOR_EQ,
                    new InputValueReader('role_filter', $_GET)
                )
            ]
        );
        return $this->renderMenu() . $list->render();
    }


    /**
     * Filtering controls in managed list + styling
     *
     * @return string
     */
    public function demo4_3()
    {
        $provider = $this->getDataProvider();
        $list = new ManagedList(
            new Repeater(
                $provider,
                [new SymfonyVarDump]
            ),
            [
                new FilterControl(
                    'name',
                    FilterOperation::OPERATOR_EQ,
                    new InputValueReader('name_filter', $_GET)
                ),
                new FilterControl(
                    'role',
                    FilterOperation::OPERATOR_EQ,
                    new InputValueReader('role_filter', $_GET)
                )
            ]
        );

        $container = new Container([$list]);
        $resources = new Resources(new AliasRegistry([
            'jquery' => '//code.jquery.com/jquery-2.1.4.min.js'
        ]), new AliasRegistry(), new IncludedResourcesRegistry());
        $styling = new BootstrapStyling($resources);
        $styling->apply($container);

        return $this->renderMenu() . $container->render();
    }
}