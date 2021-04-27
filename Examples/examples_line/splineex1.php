<?php

/**
 * JPGraph v4.0.3
 */

require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;

// Original data points
$xdata = [1, 3, 5, 7, 9, 12, 15, 17.1];
$ydata = [5, 1, 9, 6, 4, 3, 19, 12];

// Get the interpolated values by creating
// a new Spline object.
$spline = new Util\Spline($xdata, $ydata);

// For the new data set we want 40 points to
// get a smooth curve.
list($newx, $newy) = $spline->Get(50);

// Create the graph
$__width  = 300;
$__height = 200;
$g        = new Graph\Graph($__width, $__height);
$g->SetMargin(30, 20, 40, 30);
$g->title->Set('Natural cubic splines');
$g->title->SetFont(FF_ARIAL, FS_NORMAL, 12);
$g->subtitle->Set('(Control points shown in red)');
$g->subtitle->SetColor('darkred');
$g->SetMarginColor('lightblue');

//$g->img->SetAntiAliasing();

// We need a linlin scale since we provide both
// x and y coordinates for the data points.
$g->SetScale('linlin');

// We want 1 decimal for the X-label
$g->xaxis->SetLabelFormat('%1.1f');

// We use a scatterplot to illustrate the original
// contro points.
$splot = new Plot\ScatterPlot($ydata, $xdata);

$splot->mark->SetFillColor('red@0.3');
$splot->mark->SetColor('red@0.5');

// And a line plot to stroke the smooth curve we got
// from the original control points
$lplot = new Plot\LinePlot($newy, $newx);
$lplot->SetColor('navy');

// Add the plots to the graph and stroke
$g->Add($lplot);
$g->Add($splot);
$g->Stroke();
