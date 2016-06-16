<?php
namespace ViewComponents\ViewComponents\WebApp;

use ViewComponents\TestingHelpers\Application\Http\DefaultLayoutTrait;
use ViewComponents\ViewComponents\Component\CollectionView;
use ViewComponents\ViewComponents\Component\Compound;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PageSizeSelectControl;
use ViewComponents\ViewComponents\Component\Control\SelectFilterControl;
use ViewComponents\ViewComponents\Component\Control\SortingSelectControl;
use ViewComponents\ViewComponents\Component\DataView;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Component\Html\TagWithText;
use ViewComponents\ViewComponents\Component\ManagedList\RecordView;
use ViewComponents\ViewComponents\Component\Part;
use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Customization\CssFrameworks\FoundationStyling;
use ViewComponents\ViewComponents\Customization\CssFrameworks\SemanticUIStyling;
use ViewComponents\ViewComponents\Input\InputOption;
use ViewComponents\ViewComponents\Input\InputSource;
use ViewComponents\ViewComponents\Component\Container;
use ViewComponents\ViewComponents\Component\ManagedList;
use ViewComponents\ViewComponents\Component\Debug\SymfonyVarDump;
use ViewComponents\ViewComponents\Component\Html\Tag;
use ViewComponents\ViewComponents\Data\ArrayDataProvider;
use ViewComponents\ViewComponents\Data\DbTableDataProvider;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Data\Operation\SortOperation;
use ViewComponents\ViewComponents\Rendering\TemplateFinder;
use ViewComponents\ViewComponents\WebApp\Components\PersonView;
use ViewComponents\ViewComponents\Rendering\SimpleRenderer;
use ViewComponents\ViewComponents\Service\Services;

class Controller
{
    use DefaultLayoutTrait;

    protected function getUsersData()
    {
        return include(TESTING_HELPERS_DIR . '/resources/fixtures/users.php');
    }

    protected function getDataProvider($operations = [])
    {
        return (isset($_GET['use-db']) && $_GET['use-db'])
            ? new DbTableDataProvider(
                \ViewComponents\TestingHelpers\dbConnection(),
                'test_users',
                $operations
            )
            : new ArrayDataProvider(
                $this->getUsersData(),
                $operations
            );
    }

    public function index()
    {
        return $this->page('index', 'Index page');
    }

    public function demo0()
    {
        $this->layout()->addChild(new DataView("[I'm component attached directly to layout]"));
        return $this->page(null, 'Attaching components directly to layout');
    }

    /**
     * Basic usage of CollectionView component.
     *
     * @return string
     */
    public function demo1()
    {
        $view = new CollectionView($this->getUsersData(), [new PersonView]);
        return $this->page($view, 'Basic usage of CollectionView component');
    }

    /**
     * Demo1 extended by HtmlBuilder usage.
     *
     * @return string
     */
    public function demo2()
    {
        $html = Services::htmlBuilder();
        $data = $this->getUsersData();
        $view = new Container([
            $html->h1('Users List'),
            $html->hr(),
            new CollectionView($data, [new PersonView]),
            $html->hr(),
            $html->div('Footer')
        ]);
        return $this->page($view, 'HtmlBuilder');
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
            new DataView('<h1>Users List</h1>'),
            new CollectionView(
                new ArrayDataProvider(
                    $data,
                    [new SortOperation('name')]
                ),
                [new PersonView])
        ]);
        return $this->page($view, 'Array Data Provider with sorting');
    }

    /**
     * Filtering controls.
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

        $view = new Container([
            new DataView('<h1>Users List</h1>'),
            new Tag('form', [], [
                $filter1,
                $filter2,
                new Tag('button', ['type' => 'submit'], [
                    new DataView('Filter')
                ]),
            ]),
            new CollectionView(
                $provider,
                [new PersonView]
            )
        ]);
        $provider->operations()->add($filter1->getOperation());
        $provider->operations()->add($filter2->getOperation());
        return $this->page($view, 'Filtering controls');
    }


    /**
     * Filtering controls in managed list
     *
     * @return string
     */
    public function demo4_2()
    {
        $provider = $this->getDataProvider();
        $list = new ManagedList($provider, [
            new RecordView(new SymfonyVarDump()),
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
        ]);
        return $this->page($list, 'Filtering controls in managed list');
    }

    /**
     * Custom styling
     *
     * @return string
     */
    public function demo4_4()
    {
        $provider = $this->getDataProvider();
        $input = new InputSource($_GET);
        $list = new ManagedList(
            $provider,
            [
                new RecordView(new SymfonyVarDump()),
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
                new PaginationControl($input('page', 1), 5),
                new PageSizeSelectControl($input('page_size', 5), [2, 5, 10]),
                new ManagedList\ResetButton()
            ]
        );
        $list->attachTo($this->layout());
        BootstrapStyling::applyTo($list);
        return $this->page($list, 'Filtering controls in managed list + styling + pagination + InputSource');
    }

    /**
     * Hiding submit button automatically
     * @return string
     */
    public function demo5()
    {
        $provider = $this->getDataProvider();
        $input = new InputSource($_GET);
        $list = new ManagedList(
            $provider,
            [
                new RecordView(new SymfonyVarDump),
                new PaginationControl(
                    $input('page', 1),
                    10,
                    $provider
                )
            ]
        );
        BootstrapStyling::applyTo($list);
        return $this->page($list, 'Hiding submit button automatically');
    }

    /**
     * @return string
     */
    public function demo6()
    {
        $panel   = new Tag('div', ['class' => 'panel panel-success']);
        $header  = new Tag('div', ['class' => 'panel-heading'], []);
        $caption = new TagWithText('b', 'Panel Header');
        $body    = new TagWithText('div', 'Panel Body', ['class' => 'panel-body']);
        $footer  = new TagWithText('div', 'Panel Footer', ['class' => 'panel-footer']);

        $compound = new Compound([
            new Part($panel, 'panel'),
            new Part($header, 'header', 'panel'),
            new Part($caption, 'caption', 'header'),
            new Part($body, 'body', 'panel'),
            new Part($footer, 'footer', 'panel'),
        ]);

        $compound->addChild(new TagWithText('p', 'Text added after footer'));

        BootstrapStyling::applyTo($this->layout());
        return $this->page($compound, 'Usage of Compounds');
    }

    /**
     * Renderer
     *
     * @return string
     */
    public function demo7()
    {
        $renderer = new SimpleRenderer(
            new TemplateFinder([__DIR__ . '/resources/views'])
        );
        return $this->page(
            $renderer->render('demo/template1')
            . $renderer->render('demo/template_with_var', ['var' => 'ok']),
            'Renderer Usage'
        );

    }

    /**
     * Template view
     * @return string
     */
    public function demo8()
    {
        $renderer = new SimpleRenderer(
            new TemplateFinder([__DIR__ . '/resources/views'])
        );
        $view = new TemplateView('demo/template_view', [], $renderer);
        return $this->page($view, 'Template view');
    }


    protected function prepareDemo9View()
    {
        $provider = $this->getDataProvider();
        $input = new InputSource($_GET);
        $list = new ManagedList(
            $provider,
            [
                new RecordView(new SymfonyVarDump()),
                new FilterControl(
                    'name',
                    FilterOperation::OPERATOR_EQ,
                    $input('name_filter')
                ),
                (new FilterControl(
                    'role',
                    FilterOperation::OPERATOR_EQ,
                    $input('role_filter')
                ))->setView(new TemplateView('select', [
                    'options' => [
                        '' => 'All Roles',
                        'User' => 'Users',
                        'Manager' => 'Managers',
                        'Admin' => 'Admins',
                    ]
                ])),
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
                new PaginationControl($input('page', 1), 5),
                new PageSizeSelectControl($input('page_size', 5), [2, 5, 10]),
                new ManagedList\ResetButton()
            ]
        );
        $this->layout()->mainSection()->addChild($list);
    }

    /**
     * No styling
     */
    public function demo9_0()
    {
        $this->prepareDemo9View();

        return $this->page('', 'No styling');
    }

    /**
     * Bootstrap styling
     */
    public function demo9_1()
    {
        $this->prepareDemo9View();
        BootstrapStyling::applyTo($this->layout());
        return $this->page('', 'Bootstrap styling');
    }

    /**
     * Foundation styling
     */
    public function demo9_2()
    {
        $this->prepareDemo9View();
        FoundationStyling::applyTo($this->layout());
        return $this->page('', 'Foundation styling');
    }

    /**
     * Semantic UI styling
     */
    public function demo9_3()
    {
        $this->prepareDemo9View();
        SemanticUIStyling::applyTo($this->layout());
        return $this->page('', 'Semantic UI styling');
    }

    public function demo10()
    {

        $birthdayFilter = new FilterControl(
            'birthday',
            FilterOperation::OPERATOR_EQ,
            new InputOption('birthday', $_GET)
        );
        $birthdayFilter->getView()->setDataItem('inputType', 'date');
        $list = new ManagedList(
            $this->getDataProvider(),
            [
                new RecordView(new TemplateView('data_view/table')),
                $birthdayFilter
            ]
        );
        $this->layout()->mainSection()->addChild($list);
        BootstrapStyling::applyTo($this->layout());

        return $this->page(null, 'Customizing date input with Bootstrap');
    }

    public function demo11_1()
    {
        $list = new ManagedList(
            $this->getDataProvider(),
            [
                new RecordView(new SymfonyVarDump()),
                new SelectFilterControl(
                    'role',
                    [
                        'User' => 'Users',
                        'Manager' => 'Managers',
                        'Admin' => 'Admins',
                    ],
                    new InputOption('role', $_GET, 'Manager')
                ),
            ]
        );
        return $this->styledPage($list, 'SelectFilterControl + def.value');
    }

    public function demo11_2()
    {
        $list = new ManagedList(
            $this->getDataProvider(),
            [
                new RecordView(new SymfonyVarDump()),
                (new SelectFilterControl(
                    'role',
                    [
                        '' => 'All Roles',
                        'User' => 'Users',
                        'Manager' => 'Managers',
                        'Admin' => 'Admins',
                    ],
                    new InputOption('role', $_GET)
                ))->enableAutoSubmitting(),
                (new PageSizeSelectControl(new InputOption('page_size', $_GET), [5,10]))->enableAutoSubmitting(),
                new PaginationControl(new InputOption('p', $_GET, 1), 5)
            ]
        );
        return $this->styledPage($list, 'SelectFilterControl + auto-submit + PageSize');
    }

    protected function styledPage($view, $title = '')
    {
        $this->layout()->mainSection()->addChild($view);
        BootstrapStyling::applyTo($this->layout());
        return $this->page(null, $title);
    }

}
