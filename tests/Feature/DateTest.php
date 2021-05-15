<?php

namespace Tests\Feature;

use Tests\SizeFixture;
use Tests\Unit\GeneralTest;

it('renders Date Graph examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('DateTest');

it('renders Scatter Graph examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('ScatterTest');

it('renders Radar Graph examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('RadarTest');

it('renders Led Graph examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('LedTest');

it('renders Axis Examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('AxisTest');



it('renders GeneralTest Examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('GeneralTest');


it('renders BackgroundTest Examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('BackgroundTest');

it('renders ThemeTest Examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('ThemeTest');

it('renders StaticbandTest Examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('StaticbandTest');

it('renders TickTest Examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('TickTest');

it('renders ContourTest Examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('ContourTest');

it('renders RotateTest Examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('RotateTest');
