<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;



$ydata = [12, 19, 3, 9, 15, 10];

// The code to setup a very basic graph
$__width = 200;
$__height = 150;
$graph = new Graph\Graph($__width, $__height);
$example_title = 'Label background';
$subtitle_text = 'Label without background';

$graph->SetScale('intlin')
    ->SetMargin(30, 15, 40, 30)
    ->SetMarginColor('white')
    ->SetFrame(true, 'blue', 3)
    ->SetAxisLabelBackground(
        Graph\Configs::getConfig('LABELBKG_NONE'),
        'orange',
        'red',
        'lightblue',
        'red'
    )
    ->tap(
        fn ($g) => $g->title
            ->set($example_title)
            ->SetFont(
                Graph\Configs::getConfig('FF_ARIAL'),
                Graph\Configs::getConfig('FS_BOLD'),
                12
            )
    )->tap(
        fn ($g) => $g->subtitle
            ->SetFont(
                Graph\Configs::getConfig('FF_ARIAL'),
                Graph\Configs::getConfig('FS_NORMAL'),
                10
            )
            ->SetColor('darkred')
            ->Set($subtitle_text)
    )
    ->tap(fn ($g) => $g->xaxis->SetFont(
        Graph\Configs::getConfig('FF_ARIAL'),
        Graph\Configs::getConfig('FS_NORMAL'),
        9
    ))
    ->tap(fn ($g) => $g->yaxis->SetFont(
        Graph\Configs::getConfig('FF_ARIAL'),
        Graph\Configs::getConfig('FS_NORMAL'),
        9
    ))
    ->tap(fn ($g) => $g->xgrid->Show())
    ->Add(new Plot\LinePlot($ydata))
    ->Stroke();
