<?php

/**
 * JPGraph - Community Edition
 */

namespace Tests\Unit;

use Tests\SizeFixture;
use Amenadiel\JpGraph\Themes\AquaTheme;

use Amenadiel\JpGraph\Themes\GreenTheme;
use Amenadiel\JpGraph\Themes\OceanTheme;
use Amenadiel\JpGraph\Themes\OrangeTheme;
use Amenadiel\JpGraph\Themes\PastelTheme;
use Amenadiel\JpGraph\Themes\RoseTheme;
use Amenadiel\JpGraph\Themes\SoftyTheme;
use Amenadiel\JpGraph\Themes\UniversalTheme;
use Amenadiel\JpGraph\Themes\VividTheme;

it('it retrieves an array of colors  theme', function (string $theme) {
    $themeInstance = new $theme();

    expect($themeInstance->GetColorList())->toBeArray();
})->with([
    AquaTheme::class,
    RoseTheme::class,
    GreenTheme::class,
    OceanTheme::class,
    OrangeTheme::class,
    PastelTheme::class,
    SoftyTheme::class,
    RoseTheme::class,
    UniversalTheme::class,
    VividTheme::class
]);
