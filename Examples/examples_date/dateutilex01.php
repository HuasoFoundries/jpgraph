<?php

/**
 * JPGraph - Community Edition
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// Get a dataset stored in $xdata and $ydata
include __DIR__ . '/../assets/dataset01.inc.php';

$dateUtils = new Graph\Scale\DateScaleUtils();

// Setup a basic graph
$__width = 500;
$__height = 300;
$graph = new Graph\Graph($__width, $__height);

// We set the x-scale min/max values to avoid empty space
// on the side of the plot
$graph->SetScale('intlin', 0, 0, \min($xdata), \max($xdata));
$graph->SetMargin(60, 20, 40, 60);

// Setup the titles
$graph->title->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_BOLD'), 12);
$example_title = 'Development since 1984';
$graph->title->set($example_title);
$graph->subtitle->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_ITALIC'), 10);
$subtitle_text = '(Example using DateScaleUtils class)';
$graph->subtitle->Set($subtitle_text);

// Setup the labels to be correctly format on the X-axis
$graph->xaxis->SetFont(Graph\Configs::getConfig('FF_ARIAL'), Graph\Configs::getConfig('FS_NORMAL'), 8);
$graph->xaxis->SetLabelAngle(30);

// The second paramter set to 'true' will make the library interpret the
// format string as a date format. We use a Month + Year format
$graph->xaxis->SetLabelFormatString('M, Y', true);

// Get manual tick every second year
[$tickPos, $minTickPos] = $dateUtils->getTicks($xdata, Graph\Configs::getConfig('DSUTILS_YEAR2'));
$graph->xaxis->SetTickPositions($tickPos, $minTickPos);

// First add an area plot
$lp1 = new Plot\LinePlot($ydata, $xdata);
$lp1->SetWeight(0);
$lp1->SetFillColor('orange@0.85');
$graph->Add($lp1);

// And then add line. We use two plots in order to get a
// more distinct border on the graph
$lp2 = new Plot\LinePlot($ydata, $xdata);
$lp2->SetColor('orange');
$graph->Add($lp2);

// And send back to the client
$graph->Stroke();
