<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

$ydata = [11, 3, 8, 42, 5, 1, 9, 13, 5, 7];
$datax = ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'aug', 'Sep', 'Oct'];

// Create the graph. These two calls are always required
$__width  = 350;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetScale('textlog');

$graph->img->SetMargin(40, 110, 20, 40);
$graph->SetShadow();

$graph->ygrid->Show(true, true);
$graph->xgrid->Show(true, false);

// Specify the tick labels
$a = $graph->gDateLocale->GetShortMonth();
$graph->xaxis->SetTickLabels($a);

// Create the linear plot
$lineplot = new Plot\LinePlot($ydata);

// Add the plot to the graph
$graph->Add($lineplot);

$graph->title->Set('Examples 9');
$graph->xaxis->title->Set('X-title');
$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(FF_FONT1, FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1, FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1, FS_BOLD);

$lineplot->SetColor('blue');
$lineplot->SetWeight(2);

$graph->yaxis->SetColor('blue');

$lineplot->SetLegend('Plot 1');

$graph->legend->Pos(0.05, 0.5, 'right', 'center');

// Display the graph
$graph->Stroke();
