<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [12, 17, 22, 19, 5, 15];

$__width = 250;
$__height = 170;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin', 3, 35);
$graph->SetTickDensity(
    Graph\Configs::getConfig('TICKD_DENSE')
);
$graph->yscale->SetAutoTicks();
$example_title = 'Manual scale, auto ticks';
$graph->title->set($example_title);
$graph->title->SetFont(
    Graph\Configs::getConfig('FF_FONT1'),
    Graph\Configs::getConfig('FS_BOLD')
);

$line = new Plot\LinePlot($ydata);
$graph->Add($line);

// Output graph
$graph->Stroke();
