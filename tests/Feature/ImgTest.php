<?php

/**
 * JPGraph - Community Edition
 */

namespace Tests\Feature;

use Tests\SizeFixture;

$datasetName = \str_replace('.php', '', \basename(__FILE__));
$testGroupName = \str_replace('Test', '', \ucfirst($datasetName));
it(\sprintf('renders %s Graph examples correctly', $testGroupName), function (array $fixTure) {
    expect($fixTure)
        ->toMatchFixture(
            new SizeFixture($fixTure),
            ['copyOnFail' => true]
        );
})->with($datasetName);
