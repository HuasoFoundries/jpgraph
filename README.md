## JPGRAPH v4.0.0 Community Edition

You're seeing the README for version ^4, which requires PHP v7.0 or newer. If you need to run under PHP 5.6, please check [release v3.6](https://github.com/HuasoFoundries/jpgraph/tree/v3.6.21)

[![Packagist](https://img.shields.io/packagist/dm/amenadiel/jpgraph.svg)](https://packagist.org/packages/amenadiel/jpgraph) [![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph?ref=badge_shield)

[![Code Climate](https://codeclimate.com/github/HuasoFoundries/jpgraph/badges/gpa.svg)](https://codeclimate.com/github/HuasoFoundries/jpgraph)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1a7ea0cac1d84bc79545c9f6ff85cd25)](https://www.codacy.com/app/amenadiel/jpgraph?utm_source=github.com&utm_medium=referral&utm_content=HuasoFoundries/jpgraph&utm_campaign=Badge_Grade)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/badges/build.png?b=master)](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/build-status/master)
[![StyleCI](https://styleci.io/repos/39590412/shield?branch=master)](https://styleci.io/repos/39590412)
[![Code Coverage](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/?branch=master)
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph?ref=badge_shield)

For a long time, [JpGraph](http://jpgraph.net/) got stalled at version 3.5.x (see its [README](README.3.5.md)), so we decided to refactor and release a **Community Edition** with a few improvements:

-  The app was fully refactored adding namespaces, proper folder hierarchy, separating each class in its own file and stripping the use of `require` and `include` to the bare minimum
-  It requires PHP 7.0 or newer
-  it provides full composer compatibility
-  it has PSR-4 autoloading
-  it makes requirement checks so you can't go wrong
-  it has release tags, to let `composer install` use your cached packages instead of pulling from github every time
-  I stripped the docs because they are useless weight in a dependency. [You can find them here](http://jpgraph.net/doc/)
-  The Examples folder were moved upwards, althought they are now in categories. Not all of them work at this point
-  Examples pointing to features not present in the free tool were stripped from said folder (e.g. Barcodes)
-  If the chosen font isn't found, it falls back to existing fonts instead of crashing
-  If you try to use antialiasing functions not present in your current GD installation, it disables them instead of crashing

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
