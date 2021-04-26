# JPGRAPH v4.1.0 Community Edition   [![Packagist](https://img.shields.io/packagist/dm/amenadiel/jpgraph.svg)](https://packagist.org/packages/amenadiel/jpgraph) [![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph?ref=badge_shield)

First things first: This version requires PHP v7.2.0+. If you need to run this package in older versions please try
- Upgrading your PHP installation. No, really, even PHP 7.2 is past its EOL and we need to move forware to take advantage of state-of-the-art PHP 
- Otherwise, please try [release v4.0](https://github.com/HuasoFoundries/jpgraph/releases/tag/v4.0.3) for PHP 7+ support
- And if you're stuck with 5.6, please check our [release v3.6](https://github.com/HuasoFoundries/jpgraph/tree/v3.6.21)
---------

### Is this an official JPGraph package?

**No, it isn't**. The offcial package can be downloaded at [JPGraph's downloads section of their website](https://jpgraph.net/download/). They have a full featured free version with support for current and olver PHP versions.

### So, what's the point of a Community Edition?

As can be seen in [JPGraph's releases section](https://jpgraph.net/download/release.php), there was a six year pause in the release cycle of the library, during which some of us had no choice but to code our way out of PHP 5.x. And thus "Community Edition" was born.

--------------------
### What's different between the official edition and yours?

This library is a full refactor of the official code (as of v3.5, there are no ongoing efforts to keep any kind of feature parity). Notable changes include: 

- It's distributed through PHP's popular [Packagist Registry](https://packagist.org/packages/amenadiel/jpgraph) 
- It's meant to be installed and updated with [Composer](https://getcomposer.org/) as any regular dependency. Deploys and updates will pull the dependency without ever needing you to actually download or copy anything.
- It manages its own dependencies through Composer too, which means it's not your problem whatsoever and that requirement checks are performed to ensure your platform has the needed extensions
- [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/) compliant structuring of namespaces and proper folder hierarchy
- Each class goes in a file by itself, as stated in [PSR-1](https://www.php-fig.org/psr/psr-1/)
- We stripped usage of `require` and `include` to the bare minimum. Let's have the autoloader do its job
- Adheres to well known coding standards as stated in [PSR-2](https://www.php-fig.org/psr/psr-2/), eventually [PSR-12](https://www.php-fig.org/psr/psr-12/) 
- Runs integration pipelines performing unit / integration testing as well as static analysis
- As you can see in the following badges, we suck at code quality 

[![Code Climate](https://codeclimate.com/github/HuasoFoundries/jpgraph/badges/gpa.svg)](https://codeclimate.com/github/HuasoFoundries/jpgraph) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/1a7ea0cac1d84bc79545c9f6ff85cd25)](https://www.codacy.com/app/amenadiel/jpgraph?utm_source=github.com&utm_medium=referral&utm_content=HuasoFoundries/jpgraph&utm_campaign=Badge_Grade)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/badges/build.png?b=master)](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/build-status/master) [![Code Coverage](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/?branch=master)

 

-  Internal error handling that will make educate guesses to try and generate a graph even if warnings or notices are thrown elsewhere:
   -  If the chosen font isn't found, it falls back to existing fonts instead of crashing
   -  If you try to use antialiasing functions not present in your current GD installation, it disables them instead of crashing



-  I stripped the docs because they are useless weight in a dependency. [You can find them here](http://jpgraph.net/doc/)
-  Examples pointing to features not present in the free tool were stripped from said folder (e.g. Barcodes)

## How to install

Using composer

```sh
composer require amenadiel/jpgraph:^4
```

## How to use

See the [examples folder](https://github.com/amenadiel/jpgraph/tree/master/Examples) for working samples.

The examples work the same way you should use this library:

-  run `composer install`

-  require `vendor/autoload.php` it the top of your script

-  generate a graph with a snippet like the following

```php
   require_once './vendor/autoload.php';
   use Amenadiel\JpGraph\Graph;
   use Amenadiel\JpGraph\Plot;

   // Create the Pie Graph.
   $graph = new Graph\PieGraph(350, 250);
   $graph->title->Set("A Simple Pie Plot");
   $graph->SetBox(true);

   $data = array(40, 21, 17, 14, 23);
   $p1   = new Plot\PiePlot($data);
   $p1->ShowBorder();
   $p1->SetColor('black');
   $p1->SetSliceColors(array('#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3'));

   $graph->Add($p1);
   $graph->Stroke();
```

-  **important** always instance your graph (of any kind) before creating its contents. This will in turn load all needed constants to the global scope.

See the examples working by performing the following steps:

-  run `composer install`
-  run `make start` **or** `php -S localhost:8000 -t Examples`
-  Open your browser at http://localhost:8000

### Change the config

You can override some configs set on [config.inc.php](src/config.inc.php) by creating a `.env` file in your project root.
See [.env.example](.env.example) as a reference.

### Wishlist

-  Get all the examples working (half of them have yet to be transformed from the old code to the new PSR-4 format)
-  Add more tests (We need to test more classes and methods besides the ones in the examples, as well as perform more assetions on the current tests)
-  Add alternative use of [imagick](http://php.net/manual/en/imagick.setup.php)

![jpgraph_logo](https://raw.githubusercontent.com/HuasoFoundries/jpgraph/master/jpgraph_logo.jpg)

## License

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph?ref=badge_large)
