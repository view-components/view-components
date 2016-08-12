 ![Logo](https://raw.githubusercontent.com/view-components/logo/master/view-components-logo-without-text-42.png) PHP View Components 
=====
### `Flexible Framework-Agnostic UI for Enterprise Web Applications`

[![Release](https://img.shields.io/packagist/v/view-components/view-components.svg)](https://packagist.org/packages/view-components/view-components)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/view-components/view-components/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/view-components/view-components/?branch=master)
[![Build Status](https://travis-ci.org/view-components/view-components.svg?branch=master)](https://travis-ci.org/view-components/view-components)
[![Code Coverage](https://scrutinizer-ci.com/g/view-components/view-components/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/view-components/view-components/?branch=master)



**Project status: alpha since 2016-08-12**

**Have questions? [Ask in issue-tracker](https://github.com/view-components/view-components/issues/new)**.

## Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
  - [Installing into Existing Project](#installing-into-existing-project)
  - [Installing as Stand-alone Project](#installing-as-stand-alone-project)
- [Demo Application](#demo-application)
  - [Working Demo](#working-demo)
  - [Running Demo Application Locally](#running-demo-application-locally)
- [Documentation](#documentation)
- [Testing](#testing)
- [Contributing](#contributing)
- [Security](#security)
- [License](#license)

## Requirements

* PHP 5.5+ (hhvm & php7 are supported)

## Installation

#### Installing into Existing Project

The recommended way of installing the component is through [Composer](https://getcomposer.org).

Run following command from your project folder:

```bash
composer require view-components/view-components
```

#### Installing as Stand-alone Project

For running tests and demo-application bundled with this package on your system you need to install it as stand-alone project.

```
composer create-project view-components/view-components
```
This is the equivalent of doing a git clone followed by a "composer install" of the vendors.
Composer will automatically run 'post-create-project-cmd' command and that will call interactive installation.

If you want to use default settings and run it silently, just add `--no-interaction` option.

If you already cloned this repository, or you want to reinstall the package, navigate to the package folder and run `composer create-project` command without specifying package name.

If you are sure that you don't need to reinstall composer dependencies, you can execute only bundled installer: `composer run post-create-project-cmd`

This kind of installation has additional requirements:
* ext-curl
* ext-pdo_sqlite

## Demo Application

This package bundled with demo-application.

Souce code of demos available [here](https://github.com/view-components/view-components/blob/master/tests/webapp/Controller.php)

#### Working Demo

Travis CI automatically deploys web-application bundled with this package to Heroku.

Here you can see working demos: <http://view-components.herokuapp.com/>

*First run may be slow because Heroku shutting down workers when there is no traffic and starts it again on first visit*

#### Running Demo Application Locally

To run it locally, you must install this package as stand-alone project with dev-dependencis.

Then, run web-server from the package directory with the following command:

```
composer serve
```
This command uses web-server bundled with PHP.

Now, open [http://localhost:8000](http://localhost:8000) in the browser (for Windows users it will be opened automatically after starting web-server).

## Documentation

* [Components Overview](https://github.com/view-components/view-components/blob/master/doc/components.md)
* [Cookbook](https://github.com/view-components/view-components/blob/master/doc/cookbook.md)

**Work in progress. Contributions are extremely welcome!**

## Testing

This application bundled with unit and acceptance tests created with PHPUnit.

To run tests locally, you must install this package as stand-alone project with dev-dependencies.

Command for running unit and acceptance tests:

```bash
composer test
```

Command for checking code style:

```bash
composer cs
```

## Contributing

Please see [Contributing Guidelines](contributing.md) and [Code of Conduct](code_of_conduct.md) for details.

## Security

If you discover any security related issues, please email mail@vitaliy.in instead of using the issue tracker.

## License

© 2014&mdash;2016 Vitalii Stepanenko

Licensed under the MIT License. 

Please see [License File](LICENSE) for more information.
