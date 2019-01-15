<?php

/**
 * JPGraph v4.0.0
 */

require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use Amenadiel\JpGraph\Util;

// Create some "fake" regression data
$datay = [];
$datax = [];
$a     = 3.2;
$b     = 2.5;
for ($x = 0; $x < 20; ++$x) {
    $datax[$x] = $x;
    $datay[$x] = $a + $b * $x + rand(-20, 20);
}

// Create the graph
$__width  = 300;
$__height = 250;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('linlin');

$lr                  = new Util\LinearRegression($datax, $datay);
list($stderr, $corr) = $lr->GetStat();
list($xd, $yd)       = $lr->GetY(0, 19);
// Setup title
$graph->title->Set('Linear regression');
$graph->title->SetFont(FF_ARIAL, FS_BOLD, 14);

$graph->subtitle->Set('(stderr=' . sprintf('%.2f', $stderr) . ', corr=' . sprintf('%.2f', $corr) . ')');
$graph->subtitle->SetFont(FF_ARIAL, FS_NORMAL, 12);

// make sure that the X-axis is always at the
// bottom at the plot and not just at Y=0 which is
// the default position
$graph->xaxis->SetPos('min');

// Create the scatter plot with some nice colors
$sp1 = new Plot\ScatterPlot($datay, $datax);
$sp1->mark->SetType(MARK_FILLEDCIRCLE);
$sp1->mark->SetFillColor('red');
$sp1->SetColor('blue');
$sp1->SetWeight(3);
$sp1->mark->SetWidth(4);

// Create the regression line
$lplot = new Plot\LinePlot($yd);
$lplot->SetWeight(2);
$lplot->SetColor('navy');

// Add the pltos to the line
$graph->Add($sp1);
$graph->Add($lplot);

// ... and stroke
$graph->Stroke();
