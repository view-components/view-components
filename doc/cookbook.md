View Components Cookbook
========================
**Work in progress. Contributions are extremely welcome!**

## Table of contents

* [Preventing inclusion of CSS / JS resources](#1-preventing-inclusion-of-css--js-resources)
* [Changing URL's of CSS/JS resources used by default](#2-changing-urls-of-css--js-resources-used-by-default)
* [Using custom view templates and overriding core templates](#3-using-custom-view-templates-and-overriding-core-templates)
* [Creating input with date picker for filtering data](#4-creating-input-with-date-picker-for-filtering-data)

## 1. Preventing inclusion of CSS / JS resources

In some situations you may have CSS & JS resources that's required by component already included to page layout.

ViewComponents handles such situations and prevents including resources twice.

But it doesn't works if you included it to your page manually.

If you do so, mark this resources in resource manager as ignored. 

Use following methods:

* ResourceManager::ignoreCss() 
* ResourceManager::ignoreJs()

Each of listed methods accepts one argument with resource URL or alias or array of URL's or aliases. 

### Example
```php
Services::resourceManager()
    ->ignoreCss(['bootstrap', 'bootstrap-datepicker'])
    ->ignoreJs(['bootstrap', 'bootstrap-datepicker']);
```

Place this code before components rendering.

If you need to ignore css & js resources on all pages of your application, there are two options:

a. Place this code to your application bootstrap.

b. Register service provider in view-components bootstrap. This will allow to avoid execution of mentioned code on pages that don't use view-components and console commands that share same application bootstrap.


ServiceProvider class:

```php
namespace MyApp;

use ViewComponents\ViewComponents\Service\ServiceContainer;
use ViewComponents\ViewComponents\Service\ServiceId;
use ViewComponents\ViewComponents\Service\ServiceProviderInterface;
use ViewComponents\ViewComponents\Resource\ResourceManager;

class MyServiceProvider implements ServiceProviderInterface
{
    public function register(ServiceContainer $container)
    {
        $container->extend(ServiceId::RESOURCE_MANAGER, function (ResourceManager $resourceManager) {
            $resourceManager
                ->ignoreCss(['boostrap', 'bootstrap-datepicker'])
                ->ignoreJs(['bootstrap', 'bootstrap-datepicker']);
            return $resourceManager;
        });
    }
}
```

Service provider registration (place it to your application bootstrap):

```php
use MyApp\MyServiceProvider;
use ViewComponents\ViewComponents\Service\Bootstrap;

Bootstrap::registerServiceProvider(MyServiceProvider::class);

```

If you don't want to create class for service provider, you can use anonymous function:


```php
// somewhere in your app bootstrap
use ViewComponents\ViewComponents\Service\Bootstrap;
use ViewComponents\ViewComponents\Service\ServiceContainer;
use ViewComponents\ViewComponents\Service\ServiceId;
use ViewComponents\ViewComponents\Resource\ResourceManager;

Bootstrap::registerServiceProvider(function(ServiceContainer $container) {
    $container->extend(ServiceId::RESOURCE_MANAGER, function (ResourceManager $resourceManager) {
        $resourceManager
            ->ignoreCss(['boostrap', 'bootstrap-datepicker'])
            ->ignoreJs(['bootstrap', 'bootstrap-datepicker']);
        return $resourceManager;
    });
});

```

Note that logic added via Bootstrap class will work only for default resource manager stored in DI container (i.e. resources will not be ignored if you use another instances of ResourceManager).


## 2. Changing URL's of CSS / JS resources used by default

All resources used by view-components has aliases stored in configuration, therefore you need to override configuration file.
It can be done in service provider.

1. Copy vendor/view-components/view-components/resources/config/config.php to place where you store configurations.
2. Make changes in your custom configuration file.
3. Place to your application bootstrap:
```php
use ViewComponents\ViewComponents\Service\Bootstrap;
use ViewComponents\ViewComponents\Service\ServiceContainer;
use ViewComponents\ViewComponents\Service\ServiceId;
Bootstrap::registerServiceProvider(function(ServiceContainer $container) {
    $container->extend(ServiceId::CONFIG_FILE, function () {
        return '<path to your config.php>';
    });
});
```

Alternatively you can override ServiceId::CONFIG instead of ServiceId::CONFIG_FILE
(DI container stores PHP array with configuration options inside element with ServiceId::CONFIG key).

This approach will allow to merge your configuration with default one 
and avoid problems with updating view-components package related to new configuration options that can be added in further releases.

## 3. Using custom view templates and overriding core templates

To use custom view templates, you need to register path to folder containing your templates in [TemplateFinder](https://github.com/view-components/view-components/blob/master/src/Rendering/TemplateFinder.php) instance linked to used Renderer.

Code example that will work for default renderer:

```php
use ViewComponents\ViewComponents\Service\Services;
Services::renderer()->getFinder()->registerPath(dirname(__DIR__) . '/resources/views', $highPriority = true);

```
Note that second argument of `registerPath()` allows to specify folder priority, it's used when locating requested templates.
If templates with same name are placed into different registered folders, template inside folder with higher priority will be used.

If you need to override core templates, register templates folder with higher priority (pass true to second argument).

If you need to provide fallback for some templates (they can be absent in already registered paths), pass false to second argument.


## 4. Creating input with date picker for filtering data

Let's say we have a filter:
```php
$someDateFilter =  new FilterControl(
    'some_date',
    FilterOperation::OPERATOR_EQ,
    $input->option('some_date')))
);
```

It uses ["input" template](https://github.com/view-components/view-components/blob/master/resources/views/input.php) for rendering control, we need to add 'type' attribute with 'date' value to input tag.

See ["input" template](https://github.com/view-components/view-components/blob/master/resources/views/input.php) for available view variables.

Wee need to provide 'inputType' view variable. It can be done by initializing FilterControl by new TemplateView or setting view variables to existing TemplateView.

a)
```php
$someDateFilter =  new FilterControl(
    'some_date',
    FilterOperation::OPERATOR_EQ,
    $input->option('some_date'),
    new TemplateView('input', [
        'label' => 'Some date',
        'placeholder' => 'enter date here',
        'inputType' => 'date',
    ])
);
```

b)
```php
$someDateFilter->getView()->setDataItem('inputType', 'date');
```

Now some magic: if you use twitter bootstrap styling, it will automatically add bootstrap-date-picker javascript to date inputs.


