<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;

// Get a dataset stored in $xdata and $ydata
include __DIR__ . '/../assets/dataset01.inc.php';

$dateUtils = new Util\DateScaleUtils();

// Setup a basic graph
$__width  = 500;
$__height = 300;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('datlin');
$graph->SetMargin(60, 20, 40, 60);

// Setup the titles
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 12);
$graph->title->Set('Development since 1984');
$graph->subtitle->SetFont(FF_ARIAL, FS_ITALIC, 10);
$graph->subtitle->Set('(Example using the builtin date scale)');

// Setup the labels to be correctly format on the X-axis
$graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 8);
$graph->xaxis->SetLabelAngle(30);

// The second paramter set to 'true' will make the library interpret the
// format string as a date format. We use a Month + Year format
// $graph->xaxis->SetLabelFormatString('M, Y',true);

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
