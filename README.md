# Dafiti Query String Listener
[![Build Status](https://img.shields.io/travis/dafiti/querystring-listener/master.svg?style=flat-square)](https://travis-ci.org/dafiti/querystring-listener)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/dafiti/querystring-listener/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/querystring-listener/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/dafiti/querystring-listener/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/querystring-listener/?branch=master)
[![HHVM](https://img.shields.io/hhvm/dafiti/querystring-listener.svg?style=flat-square)](https://travis-ci.org/dafiti/querystring-listener)
[![Latest Stable Version](https://img.shields.io/packagist/v/dafiti/querystring-listener.svg?style=flat-square)](https://packagist.org/packages/dafiti/querystring-listener)
[![Total Downloads](https://img.shields.io/packagist/dt/dafiti/querystring-listener.svg?style=flat-square)](https://packagist.org/packages/dafiti/querystring-listener)
[![License](https://img.shields.io/packagist/l/dafiti/querystring-listener.svg?style=flat-square)](https://packagist.org/packages/dafiti/querystring-listener)

Parsing query string with multiple values and same names.

Example:
```php
//http:url.com?param=foo&filter=a:b&filter=c=d

var_dump($request->get('param'));
var_dump($request->get('filter'));
```
The example above will print:
```php
string(3) "foo"
array(3) {
  [0]=>
  string(3) "a:b"
  [1]=>
  string(3) "c:d"
}

```

## Instalation
The package is available on [Packagist](http://packagist.org/packages/dafiti/querystring-listener).
Autoloading is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compatible.
```json
{
    "require": {
        "dafiti/querystring-listener": "dev-master"
    }
}
```

## Usage

#### Basic
```php
use Dafiti\Silex\Listener;
use Silex\Application;

$app = new Application();

$app['dispatcher']->addSubscriber(new Listener\QueryString());
```

## License

MIT License

