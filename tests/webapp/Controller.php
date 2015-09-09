<?php
namespace Presentation\Framework\Demo;

use Presentation\Framework\Component\ControlView\PaginationView;
use Presentation\Framework\Input\InputOption;
use Presentation\Framework\Input\InputOptionFactory;
use Presentation\Framework\Common\ListManager;
use Presentation\Framework\Component\Container;
use Presentation\Framework\Control\FilterControl;
use Presentation\Framework\Control\PaginationControl;
use Presentation\Framework\Control\SortingSelectControl;
use Presentation\Framework\Component\ManagedList;
use Presentation\Framework\Component\Debug\SymfonyVarDump;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Data\ArrayDataProvider;
use Presentation\Framework\Data\DbTableDataProvider;
use Presentation\Framework\Data\Operation\FilterOperation;
use Presentation\Framework\Data\Operation\SortOperation;
use Presentation\Framework\HtmlBuilder;
use Presentation\Framework\Component\Repeater;
use Presentation\Framework\Component\Text;
use Presentation\Framework\Demo\Components\PersonView;
use Presentation\Framework\Resource\AliasRegistry;
use Presentation\Framework\Resource\IncludedResourcesRegistry;
use Presentation\Framework\Resource\ResourceManager;
use Presentation\Framework\Styling\Bootstrap\BootstrapStyling;

class Controller extends AbstractController
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

    public function index()
    {
        $out = '';
        $out .= $this->renderMenu();
        $out .= '<h1>Presentation/Framework Test Application</h1><h2>Index Page</h2>';

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
        $html = new HtmlBuilder(new ResourceManager(new AliasRegistry(), new AliasRegistry(), new IncludedResourcesRegistry()));
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
            new InputOption('name_filter', $_GET)
        );
        $filter2 = new FilterControl(
            'role',
            FilterOperation::OPERATOR_EQ,
            new InputOption('role_filter', $_GET)
        );

        $view = new Container([
            new Tag('form', null, [
                $filter1->getView(),
                $filter2->getView(),
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
            new InputOption('name_filter', $_GET)
        );
        $filter2 = new FilterControl(
            'role',
            FilterOperation::OPERATOR_EQ,
            new InputOption('role_filter', $_GET)
        );
        $pagination = new PaginationControl(
            new InputOption('page', $_GET, 1),
            5,
            $provider
        );

        $manager = new ListManager();
        $manager->manage($provider, [$filter1, $filter2, $pagination]);

        $view = new Container([
            new Tag('form', null, [
                $filter1->getView(),
                $filter2->getView(),
                new Tag('button', ['type' => 'submit'], [
                    new Text('Filter')
                ]),
            ]),
            new Text('<h1>Users List</h1>'),
            $repeater = new Repeater(
                $provider,
                [new PersonView]
            ),
            $pagination->getView()
        ]);

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
                    new InputOption('name_filter', $_GET)
                ),
                new FilterControl(
                    'role',
                    FilterOperation::OPERATOR_EQ,
                    new InputOption('role_filter', $_GET)
                ),
                new SortingSelectControl(
                    [
                        null => 'None',
                        'id' => 'ID',
                        'name' => 'Name',
                        'role' => 'Role',
                        'birthday' => 'Birthday',
                    ],
                    new InputOption('sort_field', $_GET),
                    new InputOption('sort_direction', $_GET)
                )
            ]
        );
        return $this->renderMenu() . $list->render();
    }

    /**
     * Filtering controls in managed list + styling + pagination + InputOptionFactory
     *
     * @return string
     */
    public function demo4_3()
    {
        $provider = $this->getDataProvider();
        $input = new InputOptionFactory($_GET);
        $list = new ManagedList(
            new Repeater(
                $provider,
                [new SymfonyVarDump]
            ),
            [
                new FilterControl(
                    'name',
                    FilterOperation::OPERATOR_EQ,
                    $input('name_filter')
                ),
                new FilterControl(
                    'role',
                    FilterOperation::OPERATOR_EQ,
                    $input('role_filter')
                ),
                new SortingSelectControl(
                    [
                        null => 'None',
                        'id' => 'ID',
                        'name' => 'Name',
                        'role' => 'Role',
                        'birthday' => 'Birthday',
                    ],
                    $input('sort_field'),
                    $input('sort_dir')
                ),
                new PaginationControl(
                    $input('page', 1),
                    10,
                    $provider
                )
            ]
        );

        // move pagination to container bottom
        $paginationView = $list->getChildrenRecursive()->find('is_a', [PaginationView::class]);
        $container = new Container([$list, $paginationView]);

        $resources = new ResourceManager(
            new AliasRegistry([
            'jquery' => '//code.jquery.com/jquery-2.1.4.min.js'
            ]),
            new AliasRegistry(),
            new IncludedResourcesRegistry()
        );

        $styling = new BootstrapStyling($resources);
        $styling->apply($container);

        return $this->renderMenu() . $container->render();
    }
}