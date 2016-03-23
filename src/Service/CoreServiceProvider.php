<?php

namespace ViewComponents\ViewComponents\Service;

use Interop\Container\ContainerInterface;
use ViewComponents\ViewComponents\HtmlBuilder;
use ViewComponents\ViewComponents\Rendering\SimpleRenderer;
use ViewComponents\ViewComponents\Rendering\TemplateFinder;
use ViewComponents\ViewComponents\Resource\AliasRegistry;
use ViewComponents\ViewComponents\Resource\IncludedResourcesRegistry;
use ViewComponents\ViewComponents\Resource\ResourceManager;
use RuntimeException;

/**
 * Service provider of presentation framework.
 *
 * This class registers presentation framework core services on the given container.
 */
class CoreServiceProvider implements ServiceProviderInterface
{
    protected $packageFolder;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->packageFolder = dirname(dirname(__DIR__));
    }

    /**
     * Registers presentation framework core services on the given container.
     *
     * @param ServiceContainer $container container instance
     */
    public function register(ServiceContainer $container)
    {
        $container->set(ServiceId::CONFIG_FILE, function () {
            return $this->packageFolder . '/resources/config/config.php';
        });

        $container->set(ServiceId::CONFIG, function (ContainerInterface $container) {
            $path = $container->get(ServiceId::CONFIG_FILE);
            if (!file_exists($path)) {
                throw new RuntimeException('Wrong presentation framework configuration path.');
            }
            $fileName = basename($path);
            list(, $extension) = explode('.', $fileName);
            switch (strtolower($extension)) {
                case 'php':
                    return include($path);
                case 'json':
                    return json_decode(file_get_contents($path));
            }
            throw new RuntimeException('Unsupported configuration file type.');
        });

        $container->set(ServiceId::RENDERER, function (ContainerInterface $container) {
            return new SimpleRenderer($container->get(ServiceId::TEMPLATE_FINDER));
        });

        $container->set(ServiceId::TEMPLATE_FINDER, function () {
            return new TemplateFinder([$this->packageFolder . '/resources/views']);
        });

        $container->set(ServiceId::RESOURCE_MANAGER, function (ContainerInterface $container) {
            $config = $container->get(ServiceId::CONFIG);
            return new ResourceManager(
                new AliasRegistry(isset($config['js_aliases']) ? $config['js_aliases'] : []),
                new AliasRegistry(isset($config['css_aliases']) ? $config['css_aliases'] : []),
                new IncludedResourcesRegistry()
            );
        });

        $container->set(ServiceId::HTML_BUILDER, function (ContainerInterface $container) {
            return new HtmlBuilder($container->get(ServiceId::RESOURCE_MANAGER));
        });

        $container->set(ServiceId::BOOTSTRAP_STYLING_CONFIG, function () {
            return include $this->packageFolder . '/resources/config/styling/twitter_bootstrap.php';
        });

        $container->set(ServiceId::FOUNDATION_STYLING_CONFIG, function () {
            return include $this->packageFolder . '/resources/config/styling/foundation.php';
        });

        $container->set(ServiceId::SEMANTIC_UI_STYLING_CONFIG, function () {
            return include $this->packageFolder . '/resources/config/styling/semantic-ui.php';
        });
    }
}
