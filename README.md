PHP Presentation Framework
=====

[![Release](https://img.shields.io/packagist/v/presentation/framework.svg)](https://packagist.org/packages/presentation/framework)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/presentation-framework/presentation-framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/presentation-framework/presentation-framework/?branch=master)
[![Build Status](https://travis-ci.org/presentation-framework/presentation-framework.svg?branch=master)](https://travis-ci.org/presentation-framework/presentation-framework)
[![Code Coverage](https://scrutinizer-ci.com/g/presentation-framework/presentation-framework/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/presentation-framework/presentation-framework/?branch=master)

**Project status: pre-alpha**

## Requirements

* php 5.4+

## Installation

The recommended way of installing the component is through [Composer](https://getcomposer.org).

Run following command:

```bash
composer require presentation/framework
```
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
