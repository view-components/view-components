PHP View Components
=====
### `Flexible UI for Enterprise Web Applications`

[![Release](https://img.shields.io/packagist/v/view-components/view-components.svg)](https://packagist.org/packages/view-components/view-components)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/view-components/view-components/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/view-components/view-components/?branch=master)
[![Build Status](https://travis-ci.org/view-components/view-components.svg?branch=master)](https://travis-ci.org/view-components/view-components)
[![Code Coverage](https://scrutinizer-ci.com/g/view-components/view-components/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/view-components/view-components/?branch=master)


**Project status: pre-alpha**

ViewComponents package allows to build flexible HTML user interface based on components.
It provides interoperability via object-oriented API and foundation for UI architecture.

## Requirements

* PHP 5.5+ (hhvm & php7 are supported)
* [ext_intl](http://php.net/manual/en/book.intl.php) ([bundled with PHP](http://php.net/manual/en/intl.installation.php) as of PHP 5.3.0)
* ext_curl required for running package tests

## Installation

### Installing into Existing Project

The recommended way of installing the component is through [Composer](https://getcomposer.org).

Run following command from your project folder:

```bash
composer require view-components/view-components
```

### Installing as Stand-alone Project

For running tests and demo-application bundled with this package on your system you need to install it as stand-alone project.

```
composer create-project view-components/view-components
```

This is the equivalent of doing a git clone followed by a "composer install" of the vendors.
Composer will automatically run 'post-create-project-cmd' command and that will call interactive installation.

If you want to use default settings and run it silently, just add `--no-interaction` option.

If you already cloned this repository, or you want to reinstall package, navigate to package folder and run `composer create-project` without specifying package name.

If you are sure that you don't need to reinstall composer dependencies, you can execute only bundled installer: `composer run post-create-project-cmd`

## Overview


##### 1. Components hierarchy

Сomponents can be organized in a tree structure. 
[nayjest/tree package](https://github.com/Nayjest/Tree) is used for this purpose.
Each component implements [Nayjest\Tree\ChildNodeInterface](https://github.com/Nayjest/Tree/blob/master/src/ChildNodeInterface.php) and
components able to contain another components implements [Nayjest\Tree\ParentNodeInterface](https://github.com/Nayjest/Tree/blob/master/src/ParentNodeInterface.php)

##### 2. Rendering

###### `ComponentInterface::render() : string`

Renders component.



###### `ComponentInterface::__toString() : string`

Returns rendering result  when object is treated like a string, i.e. components can be used as variables containing strings:

Example 1:
```php
<?php
use ViewComponents\ViewComponents\Component\Html\Tag;
?>
<p>Some text</p>
<?= new Tag('hr') ?>
```
Example 2:
```php
<?php
use \ViewComponents\ViewComponents\Component\DataView;
$text = new DataView("I'm component");
echo "Component output: $text";
```

See [PHP Magic Methods: __toString()](http://www.php.net/manual/en/language.oop5.magic.php#object.tostring)



##### `$component->renderChildren() : string`

Renders child components.

##### 3. Compound components

Compound components are composed from smaller components that implements PartInterface or wrapped into Part instance.

## Demo Application

This package bundled with demo-application.

Souce code of demos available [here](https://github.com/view-components/view-components/blob/master/tests/webapp/Controller.php)

### Demo Application on Heroku

Travis CI automatically deploys web-application bundled with this package to Heroku.

Here you can see working demos: <http://view-components.herokuapp.com/>

*First run may be slow becouse Heroku shutting down workers when there is no traffic and starts it again on first visit*

### Running Demo Application Locally

To run it locally, you must install this package as stand-alone project with dev-dependencis.

Then, run web-server from the package directory with the following command:

```
composer serve
```
This command uses web-server bundled with PHP.

Now, open [http://localhost:8000](http://localhost:8000) in browser (for Windows users it will be opened automatically after starting web-server).

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mail@vitaliy.in instead of using the issue tracker.

## License

© 2014&mdash;2016 Vitalii Stepanenko

Licensed under the MIT License. 

Please see [License File](LICENSE) for more information.
