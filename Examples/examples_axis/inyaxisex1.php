<?php

/**
 *  Graph\Configs::getConfig('JPG')raph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Callback to negate the argument
$_cb_negate = function ($aVal) {
    return round(-$aVal);
};

// A fake depth curve
$ydata = [0, 1, 4, 5, 8, 9, 10, 14, 16, 16, 16, 18, 20, 20, 20, 22, 22.5, 22, 19, 19, 15, 15, 15, 15, 10, 10, 10, 6, 5, 5, 5, 4, 4, 2, 1, 0];

// Negate all data
$n = count($ydata);
for ($i = 0; $i < $n; ++$i) {
    $ydata[$i] = round(-$ydata[$i]);
}

// Basic graph setup
$__width  = 400;
$__height = 300;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');
$graph->img->SetMargin(50, 50, 60, 40);
$graph->SetMarginColor('darkblue');
$graph->SetColor('darkblue');
$graph->SetAxisStyle(Graph\Configs::getConfig('AXSTYLE_BOXOUT'));
$example_title = 'Depth curve. Dive #2';
$example_title = $example_title;
$graph->title->set($example_title);
$graph->title->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_BOLD'));
$graph->title->SetColor('white');

$graph->subtitle->Set('(Negated Y-axis)');
$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_FONT1'), Graph\Configs::getConfig('FS_NORMAL'));
$graph->subtitle->SetColor('white');

// Setup axis
$graph->yaxis->SetLabelFormatCallback($_cb_negate);
$graph->xaxis->SetColor('lightblue', 'white');
$graph->yaxis->SetColor('lightblue', 'white');
$graph->ygrid->SetColor('blue');

$lp1 = new Plot\LinePlot($ydata);
$lp1->SetColor('yellow');
$lp1->SetWeight(2);

$graph->Add($lp1);
$graph->Stroke();
