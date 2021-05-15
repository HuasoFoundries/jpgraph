<?php

namespace Tests\Feature;

use Tests\SizeFixture;

it('renders Line Graph examples correctly', function (array $fixTure) {
    expect($fixTure)->toMatchFixture(new SizeFixture($fixTure));
})->with('LineTest');
