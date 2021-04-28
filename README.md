
<h1 align="center">JpGraph Community Edition v4.2.0</h1>

<p align="center">
<a href="https://packagist.org/packages/amenadiel/jpgraph">
<img src="https://img.shields.io/packagist/v/amenadiel/jpgraph">
</a>
<a href="https://packagist.org/packages/amenadiel/jpgraph">
<img src="https://img.shields.io/packagist/dm/amenadiel/jpgraph.svg">
</a>
<a href="https://app.fossa.io/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph?ref=badge_shield">
<img src="https://app.fossa.io/api/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph.svg?type=shield">
</a>
<a href="https://github.com/HuasoFoundries/jpgraph/actions/workflows/tests.yml">
<img src="https://github.com/HuasoFoundries/jpgraph/actions/workflows/tests.yml/badge.svg">
</a>
</p> 

**JpGraph Community Edition** was created as a [Composer](https://getcomposer.org/) friendly port of [JpGraph v3.5](README.3.5.md). With time and through incremental refactorings, it became a whole different library, with [PSR-1](https://www.php-fig.org/psr/psr-1/) and [PSR-2](https://www.php-fig.org/psr/psr-2/) compliant codebase, namespaces and folder hierarchy enabling [PSR-4](https://www.php-fig.org/psr/psr-4/) autoloading, and more.

We are now, at most, distant cousins with the current official release.

Refactoring is an ongoing effort and we ensure editions and additions don't hurt our (already poor) metrics

<p align="center">
<a href="https://codeclimate.com/github/HuasoFoundries/jpgraph/maintainability"><img src="https://api.codeclimate.com/v1/badges/f85b91e9a85eb4b43059/maintainability" /></a> <a href="https://www.codacy.com/gh/HuasoFoundries/jpgraph/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=HuasoFoundries/jpgraph&amp;utm_campaign=Badge_Grade"><img src="https://app.codacy.com/project/badge/Grade/eb29aeb298ea4379a281db35d55ddeb1"/></a>
<a href="https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/?branch=master"><img src="https://scrutinizer-ci.com/g/HuasoFoundries/jpgraph/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality" /></a>
      <a href="https://codecov.io/gh/HuasoFoundries/jpgraph">
        <img src="https://codecov.io/gh/HuasoFoundries/jpgraph/branch/master/graph/badge.svg?token=VESbMV2rS4"/>
      </a>
    </p>

---------


## What is JPGraph Community Edition?

As can be seen in [their releases section](https://jpgraph.net/download/release.php), there was a six year pause in JPGraph release cycle, during which some of us had no choice but to code our way out of PHP 5.x. And thus "Community Edition" was born. From then on, this library evolved on its own and completely diverged from the official packages.

In general terms, JPGraph CE relies in PHP's thriving ecosystem. We aim to be a simple dependency you can seamlessly integrate in your app. JPGraph CE aligns with [PHP Standards Reccomendations](https://www.php-fig.org/psr/) as published by the [PHP Framework Interoperability Group](https://www.php-fig.org/), and when presented with the choice, will always pick an agnostic implementation over custom ones that reinvent the wheel. A lot of code has been trimmed and refactored with this purpose and a lot more is waiting to undergo such a change.

- Distrbution through PHP's popular [Packagist Registry](https://packagist.org/packages/amenadiel/jpgraph)
- Relies in [Composer](https://getcomposer.org/), so you don't need to manually download or copy anything, nor check for platform and dependency requirements yourself.
- [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/) compliant structure. No need to resort to `require` or `include` in your code.
- Sensible fallbacks to handle missing fonts or particular GD version features availability.
- IDE friendly, allowing for autocompletion and go-to-definition where supported.
- [Integration pipelines](https://github.com/HuasoFoundries/jpgraph/actions/workflows/tests.yml) checking new releases compatibility against different PHP versions
- New or refactored code is expected to observe [PSR-1](https://www.php-fig.org/psr/psr-1/) and [PSR-2](https://www.php-fig.org/psr/psr-2/) coding standards (Eventually [PSR-12](https://www.php-fig.org/psr/psr-12/) as well).

Comparing against the original v3.5 codebase, we also stripped examples or incomplete implementation of graph types exclusive to v3.5 pro (e.g. Barcodes).

### Things that JPGraph CE is NOT

- This library **is NOT an official JPGraph package**. The offcial package can be downloaded at [JPGraph's downloads section of their website](https://jpgraph.net/download/). They have a full featured free version with support for current and olver PHP versions.
- Endorsed in any way by JPGraph's creator company [Asial](https://www.asial.co.jp/)
- A composer enabled wrapper for the official package
- A drop-in replacement for the official package. We do not claim nor offer any kind of feature parity with the official package.



## Requirements And Installation

This version requires PHP v7.4.0+. If you need to install this library package in older PHP environments please try

- Upgrading your PHP installation. (No, really, even PHP 7.3 is approaching EOL, and PHP 7.4 brings a lot of enhancements we need to take advantage of)
- for PHP v7.2+  please try [release v4.1.x](https://github.com/HuasoFoundries/jpgraph/releases/tag/v4.1.0)
- for PHP v7.0+  please try [release v4.0.x](https://github.com/HuasoFoundries/jpgraph/releases/tag/v4.0.3)
- for PHP v5.6+ please check [release v3.6.x](https://github.com/HuasoFoundries/jpgraph/tree/v3.6.21)

Install it Using composer

```sh
composer require amenadiel/jpgraph:^4
```

## How to use

See the [examples folder](https://github.com/amenadiel/jpgraph/tree/master/Examples) for working samples.

The examples work the same way you should use this library:

- run `composer install`

- require `vendor/autoload.php` it the top of your script

- generate a graph with a snippet like the following

```php
   require_once 'PATH/TO/vendor/autoload.php';

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

- **important** make sure to instance the  Graph (or Graph child class) before its content (for example, Plots). Doing this will load the global configuration to the global scope. Yeah, we know we are polluting the global scope with dozens of constants, but we are still refactoring :shrug: .

See the examples working by performing the following steps:

- run `composer install`
- run `make start` **or** `php -S localhost:8000 -t Examples`
- Open your browser at <http://localhost:8000>

### Change the config

You can override some configs set on [config.inc.php](src/config.inc.php) by creating a `.env` file in your project root.
See [.env.example](.env.example) as a reference.

# Contributors ✨

<!-- ALL-CONTRIBUTORS-BADGE:START - Do not remove or modify this section -->
[![All Contributors](https://img.shields.io/badge/all_contributors-11-orange.svg?style=flat-square)](#contributors-)
<!-- ALL-CONTRIBUTORS-BADGE:END -->

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="https://github.com/zhangsean"><img src="https://avatars.githubusercontent.com/u/2536402?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Sean Zhang</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=zhangsean" title="Code">💻</a></td>
    <td align="center"><a href="http://shawnmc.cool"><img src="https://avatars.githubusercontent.com/u/560749?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Shawn McCool</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=ShawnMcCool" title="Code">💻</a></td>
    <td align="center"><a href="https://youtube.com/c/DiasDeDev?sub_confirmation=1"><img src="https://avatars.githubusercontent.com/u/6991415?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Vinicius Dias</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=CViniciusSDias" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/PauluzzNL"><img src="https://avatars.githubusercontent.com/u/5946360?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Paul van der Knaap</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=PauluzzNL" title="Code">💻</a></td>
    <td align="center"><a href="https://morselli.fr"><img src="https://avatars.githubusercontent.com/u/1091072?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Florent Morselli</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=Spomky" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/murrant"><img src="https://avatars.githubusercontent.com/u/39462?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Tony Murray</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=murrant" title="Code">💻</a></td>
    <td align="center"><a href="https://incoherent.ch"><img src="https://avatars.githubusercontent.com/u/973653?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Andreas</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=iquito" title="Code">💻</a></td>
  </tr>
  <tr>
    <td align="center"><a href="https://corwatts.com"><img src="https://avatars.githubusercontent.com/u/220260?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Corey Watts</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=CorWatts" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/eisberg"><img src="https://avatars.githubusercontent.com/u/9015003?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Alexander Rakushin</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=eisberg" title="Code">💻</a></td>
    <td align="center"><a href="https://github.com/abidaks"><img src="https://avatars.githubusercontent.com/u/20839618?v=4?s=50" width="50px;" alt=""/><br /><sub><b>Muhammad Abid</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/commits?author=abidaks" title="Code">💻</a></td>
    <td align="center"><a href="http://www.whiletrue.it"><img src="https://avatars.githubusercontent.com/u/683688?v=4?s=50" width="50px;" alt=""/><br /><sub><b>WhileTrue</b></sub></a><br /><a href="https://github.com/HuasoFoundries/jpgraph/issues?q=author%3Aformikaio" title="Bug reports">🐛</a></td>
  </tr>
</table>

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!

______________

### Wishlist

- Get all the examples working (half of them have yet to be transformed from the old code to the new PSR-4 format)
- Add more tests (We need to test more classes and methods besides the ones in the examples, as well as perform more assetions on the current tests)
- Add alternative use of [imagick](http://php.net/manual/en/imagick.setup.php)

![jpgraph_logo](https://raw.githubusercontent.com/HuasoFoundries/jpgraph/master/jpgraph_logo.jpg)

## Similar Projects

- [ztec/JpGraph](https://github.com/ztec/JpGraph)

## License

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2FHuasoFoundries%2Fjpgraph?ref=badge_large)
