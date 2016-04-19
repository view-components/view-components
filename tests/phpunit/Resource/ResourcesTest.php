<?php
namespace ViewComponents\ViewComponents\Test\Resource;

use ViewComponents\ViewComponents\Base\ViewComponentInterface;
use ViewComponents\ViewComponents\Resource\AliasRegistry;
use ViewComponents\ViewComponents\Resource\IncludedResourcesRegistry;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use PHPUnit_Framework_TestCase;

class ResourcesTest extends PHPUnit_Framework_TestCase
{
    protected function make($jsAliases = [], $cssAliases = [])
    {
        $jsRegistry = new AliasRegistry($jsAliases);
        $cssRegistry = new AliasRegistry($cssAliases);
        $included = new IncludedResourcesRegistry();
        return new ResourceManager($jsRegistry, $cssRegistry, $included);
    }

    protected static function assertRendersJs(ViewComponentInterface $component, $url)
    {
        $output = $component->render();
        self::assertStringStartsWith('<script ', $output);
        self::assertContains("src=\"$url\"", $output);
    }

    protected static function assertRendersCss(ViewComponentInterface $component, $url)
    {
        $output = $component->render();
        self::assertStringStartsWith('<link ', $output);
        self::assertContains("href=\"$url\"", $output);
    }

    public function testCss()
    {
        $resources = $this->make();
        self::assertRendersCss(
            $resources->css('/main.css'),
            '/main.css'
        );
    }

    public function testJs()
    {
        $resources = $this->make();
        self::assertRendersJs(
            $resources->js('/main.js'),
            '/main.js'
        );
    }

    public function testUniqueCss()
    {
        $resources = $this->make();
        self::assertRendersCss(
            $resources->css('/main.css'),
            '/main.css'
        );
        $sameCssAgain = $resources->css('/main.css')->render();
        self::assertEmpty(
            $sameCssAgain,
            'Same resource must not be included twice.'
        );
    }

    public function testJsAlias()
    {
        $resources = $this->make(['jquery' => 'http://example.com/jquery.js']);
        self::assertRendersJs(
            $resources->js('jquery'),
            'http://example.com/jquery.js'
        );
    }

    public function testCssAlias()
    {
        $resources = $this->make([], ['main' => '/main.css']);
        self::assertRendersCss(
            $resources->css('main'),
            '/main.css'
        );
    }

    public function testIgnoreCss()
    {
        $resources = $this->make([], [
            '1' => '/1.css',
            '2' => '/2.css',
            '3' => '/3.css',
            '4' => '/4.css'
        ]);
        $res = $resources->ignoreCss(['1', '/3.css']);
        self::assertTrue($res === $resources);
        self::assertEmpty($resources->css('1')->render());
        self::assertRendersCss($resources->css('2'), '/2.css');
        // should not render same css again
        self::assertEmpty($resources->css('2')->render());
        self::assertEmpty($resources->css('3')->render());

        $res = $resources->ignoreCss('4');
        self::assertTrue($res === $resources);
        self::assertEmpty($resources->css('4')->render());
    }

    public function testIgnoreJs()
    {
        $resources = $this->make([
            '1' => '/1.js',
            '2' => '/2.js',
            '3' => '/3.js',
            '4' => '/4.js'
        ]);
        $res = $resources->ignoreJs(['1', '/3.js']);
        self::assertTrue($res === $resources);
        self::assertEmpty($resources->js('1')->render());
        self::assertRendersJs($resources->js('2'), '/2.js');
        // should not render same js again
        self::assertEmpty($resources->js('2')->render());
        self::assertEmpty($resources->js('3')->render());

        $res = $resources->ignoreJs('4');
        self::assertTrue($res === $resources);
        self::assertEmpty($resources->js('4')->render());
    }
}
