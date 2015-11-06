PHP Presentation Framework
=====
### `Flexible UI for Enterprise Web Applications`

[![Release](https://img.shields.io/packagist/v/presentation/framework.svg)](https://packagist.org/packages/presentation/framework)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/presentation-framework/presentation-framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/presentation-framework/presentation-framework/?branch=master)
[![Build Status](https://travis-ci.org/presentation-framework/presentation-framework.svg?branch=master)](https://travis-ci.org/presentation-framework/presentation-framework)
[![Code Coverage](https://scrutinizer-ci.com/g/presentation-framework/presentation-framework/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/presentation-framework/presentation-framework/?branch=master)


**Project status: pre-alpha**

Presentation Framework allows to build flexible HTML user interface based on components.
It provides interoperability via object-oriented API and foundation for UI architecture.

## Requirements

* php 5.5+

## Installation

The recommended way of installing the component is through [Composer](https://getcomposer.org).

Run following command:

```bash
composer require presentation/framework
```

## Overview

Components are basic building blocks of UI.
Presentation Framework provides basic interface of UI components, see [ComponentInterface](https://github.com/presentation-framework/presentation-framework/blob/master/src/Base/ComponentInterface.php)

#### ComponentInterface reference

##### 1. Components hierarchy

Сomponents can be organized in a tree structure. 
[nayjest/tree package](https://github.com/Nayjest/Tree) is used for this purpose.
Each component implements [Nayjest\Tree\ChildNodeInterface](https://github.com/Nayjest/Tree/blob/master/src/ChildNodeInterface.php) and [Nayjest\Tree\ParentNodeInterface](https://github.com/Nayjest/Tree/blob/master/src/ParentNodeInterface.php)

##### 2. Rendering

###### `ComponentInterface::render() : string`

Renders component.

###### `ComponentInterface::__toString() : string`

Returns rendering result  when object is treated like a string, i.e. components can be used as variables containing strings:

Example 1:
```php
<?php
use Presentation\Framework\Component\Html\Tag;
?>
<p>Some text</p>
<?= new Tag('hr') ?>
```
Example 2:
```php
<?php
use \Presentation\Framework\Component\Text;
$text = new Text("I'm component");
echo "Component output: $text";
```

See [PHP Magic Methods: __toString()](http://www.php.net/manual/en/language.oop5.magic.php#object.tostring)

###### `$component->renderChildren() : string`

Renders child components

##### 3. Sorting

If root component has sorting enabled, child components will be rendered in specified order.
By default it's enabled, but can be turned of in performance reasons or specific business logic requirements.

Sotring mechanism provides stable sort, i. e. components with equal values returned by getSortPosition() method will be rendered in same order as it placed to components collection. Therefore rendering order of components  can be controlled by two ways: it's natural order in collection and specifying concrete positions (this way has higher priority).

###### `$component->isSortable() : bool`
Returns true if component has sorting enabled.

###### `$component->setSortable(bool $value) : $this`
Enables or disables children sorting

###### `$component->setSortPosition(int $position) : $this`

Specifies position for sorting. 
If sorting is enabled in parent component, children will be sorted by $sortPosition ascending on rendering.

##### `$component->getSortPosition() : int`
Returns position for sorting. Default value is 1

##### 4. Visibility

Each component has property responsive for visibility. If component isn't visible, it's render() method will return empty string.

This does not matters when calling renderChildren() manually.

##### `$component->setVisible(bool $value) : $this`

Sets component visibility

##### `$component->hide() : $this`
Method acts same way like calling  `$component->setVisible(false);`

##### `$component->show() : $this`
Method acts same way like calling  `$component->setVisible(true);`

##### `$component->isVisible() : bool`
Returns `true` if component is visible and `false` otherwise

##### 5. Events
Presentation Framework uses [Événement](https://github.com/igorw/evenement) package for event dispatching.
Components implements (Evenement\EventEmitterInterface)[https://github.com/igorw/evenement/blob/master/src/Evenement/EventEmitterInterface.php].

In addition to EventEmitterInterface, components of Presentation Framework provides methods for working with it's concrete events.

##### `$component->onRender(callable $callback) : $this`
Attaches handler for 'render' event.

##### 6. Miscellaneous

Components has setter & getter for `componentName` property used for identifying components programmatically.

##### `$component->getComponentName() : string|null`
Sets component name

##### `$component->setComponentName(string|null $name) : $this`
Gets component name

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mail@vitaliy.in instead of using the issue tracker.

## Testing

#### Overview

The package bundled with phpunit tests and web-application for integration/acceptance tests using codeception.

#### Running Unit Tests

Just execute phpunit from package folder.

```bash
phpunit
```
Package dependencies must be installed via composer (just run composer install).

#### Running Acceptance Tests

Package dependencies must be installed via composer (just run composer install).

**Step 1:** Install test web-application.

```bash
php tests/webapp/install.php
```
**Step 2:** Start test web-application server. Do not close terminal with running server.
```bash
php -S localhost:9000 tests/webapp/index.php
```
**Step 3:** Open new terminal window.

**Step 4:** Build codeception tests.
```bash
php vendor/bin/codecept build
```
**Step 5:** Run codeception tests.
```bash
php vendor/bin/codecept run acceptance
```

## License

© 2014 &mdash; 2015 Vitalii Stepanenko

Licensed under the MIT License. 

Please see [License File](LICENSE) for more information.
