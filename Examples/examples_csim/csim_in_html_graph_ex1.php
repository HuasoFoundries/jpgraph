<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$datay = [12, 26, 9, 17, 31];

// Create the graph.
$__width = 400;
$__height = 250;
$graph = new Graph\Graph($__width, $__height);
$graph->SetScale('textlin');
$graph->SetMargin(50, 80, 20, 40);

// Create a bar pot
$bplot = new Plot\BarPlot($datay);

$n = \count($datay); // Number of bars

global $_wrapperfilename;

// Create targets for the image maps. One for each column
$targ = [];
$alt = [];
$wtarg = [];

for ($i = 0; $i < $n; ++$i) {
    $urlarg = 'clickedon=' . ($i + 1);
    $targ[] = $_wrapperfilename . '?' . $urlarg;
    $alt[] = 'val=%d';
    $wtarg[] = '';
}
$bplot->SetCSIMTargets($targ, $alt, $wtarg);

$graph->Add($bplot);
$example_title = 'Multiple Image maps';
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->title->SetCSIMTarget('#45', 'Title for Bar', '_blank');

$graph->yaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->yaxis->title->SetCSIMTarget('#55', 'Y-axis title');
$graph->yaxis->title->Set('Y-title');

$graph->xaxis->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->xaxis->title->SetCSIMTarget('#55', 'X-axis title');
$graph->xaxis->title->Set('X-title');

// Send back the image when we are called from within the <img> tag
$graph->StrokeCSIMImage();
