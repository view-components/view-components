<?php
namespace Nayjest\ViewComponents\Demo;

use Nayjest\ViewComponents\Components\Container;
use Nayjest\ViewComponents\Components\Controls\Filter;
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

class Controller
{
    protected function getUsersData()
    {
        return [
            ['id' => '1', 'name' => 'John', 'role' => 'Admin', 'birthday' => '1970-01-16'],
            ['id' => '2', 'name' => 'Max', 'role' => 'Manager', 'birthday' => '1980-11-20'],
            ['id' => '3', 'name' => 'Anna', 'role' => 'Manager', 'birthday' => '1987-03-30'],
            ['id' => '4', 'name' => 'Lisa', 'role' => 'User', 'birthday' => '1989-04-21'],
            ['id' => '5', 'name' => 'Eric', 'role' => 'User', 'birthday' => '1990-10-23'],
            ['id' => '6', 'name' => 'David', 'role' => 'User', 'birthday' => '1967-04-09'],
            ['id' => '7', 'name' => 'Bruce', 'role' => 'User', 'birthday' => '1977-09-14'],
            ['id' => '8', 'name' => 'Julia', 'role' => 'User', 'birthday' => '1994-03-05'],
        ];
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
        return '<h1>Nayjest/ViewComponents test app</h1><h2>Index Page</h2>';
    }

    public function home()
    {
        return 'Welcome!';
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
        return $view->render();
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
        return $view->render();
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
        return $view->render();
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
        return $view->render();
    }

}