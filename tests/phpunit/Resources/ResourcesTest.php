<?php
namespace Presentation\Framework\Test\Resources;

use Presentation\Framework\Resources\AliasRegistry;
use Presentation\Framework\Resources\IncludedResourcesRegistry;
use Presentation\Framework\Resources\ResourceManager;
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

    public function testCss()
    {
        $resources = $this->make();

        $css = $resources->css('/main.css')->render();
        self::assertStringStartsWith('<link ', $css);
        self::assertContains('href="/main.css"', $css);
    }

    public function testJs()
    {
        $resources = $this->make();

        $js = $resources->js('/main.js')->render();
        self::assertStringStartsWith('<script ', $js);
        self::assertContains('src="/main.js"', $js);
    }

    public function testUniqueCss()
    {
        $resources = $this->make();
        $resources->css('/main.css')->render();
        $css = $resources->css('/main.css')->render();
        self::assertEmpty(
            $css,
            'Same resource must not be included twice.'
        );
    }

    public function testJsAlias()
    {
        $resources = $this->make(['jquery' => 'http://example.com/jquery.js']);

        // test alias
        $js = $resources->js('jquery')->render();
        self::assertStringStartsWith('<script', $js);
        self::assertContains('src="http://example.com/jquery.js"', $js);
    }
}
