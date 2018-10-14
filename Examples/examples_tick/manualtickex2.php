<?php

/**
 * JPGraph v3.6.21
 */

//
// Basic example on how to use custom tickmark feature to have a label
// at the start of each month.
//
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;

//
// Create some random data for the plot. We use the current time for the
// first X-position
//
$f                   = new Util\FuncGenerator('cos($x)+1.5*cos(2*$x)');
list($datax, $datay) = $f->E(0, 10);

// Now get labels at 1/2 PI intervall
$tickPositions    = [];
$tickLabels       = [];
$tickPositions[0] = 0;
$tickLabels[0]    = '0';
for ($i = 1; $i / 2 * M_PI < 11; ++$i) {
    $tickPositions[$i] = $i / 2 * M_PI;
    if ($i % 2) {
        $tickLabels[$i] = $i . '/2' . Graph\SymChar::Get('pi');
    } else {
        $tickLabels[$i] = ($i / 2) . Graph\SymChar::Get('pi');
    }
}

$n    = count($datax);
$xmin = $datax[0];
$xmax = $datax[$n - 1];

//
// The code to setup a very basic graph
//
$__width  = 400;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);

//
// We use an integer scale on the X-axis since the positions on the X axis
// are assumed to be UNI timestamps
$graph->SetScale('linlin', 0, 0, $xmin, $xmax);
$graph->title->Set('Example with manual tick labels');
$graph->title->SetFont(FF_ARIAL, FS_NORMAL, 12);

//
// Make sure that the X-axis is always at the bottom of the scale
// (By default the X-axis is alwys positioned at Y=0 so if the scale
// doesn't happen to include 0 the axis will not be shown)
$graph->xaxis->SetPos('min');

// Now set the tic positions
$graph->xaxis->SetMajTickPositions($tickPositions, $tickLabels);

// Use Times font
$graph->xaxis->SetFont(FF_TIMES, FS_NORMAL, 10);
$graph->yaxis->SetFont(FF_TIMES, FS_NORMAL, 10);

// Add a X-grid
$graph->xgrid->Show();

// Create the plot line
$p1 = new Plot\LinePlot($datay, $datax);
$p1->SetColor('teal');
$graph->Add($p1);

// Output graph
$graph->Stroke();
