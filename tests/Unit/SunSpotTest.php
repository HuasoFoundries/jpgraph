<?php

/**
 * JPGraph - Community Edition
 */

namespace Tests\Unit;

use Tests\SizeFixture;

$datasetName = \str_replace('.php', '', \basename(__FILE__));
$testGroupName = \str_replace('Test', '', \ucfirst($datasetName));
it(\sprintf('verifies basic mime info of images for %s Graphs', $testGroupName), function (array $fixTure) {
    //$this->line($this->getPrintableTestCaseName(), 'info');
    tap(new SizeFixture($fixTure), function ($sizeFixture) {
        if ($sizeFixture->hasDimensions()) {
            expect($sizeFixture)->toMatchFixture($sizeFixture);
        } else {
            expect($sizeFixture)->toMatchImageType($sizeFixture);
        }
    });
})->with($datasetName . 'PlainFile');
