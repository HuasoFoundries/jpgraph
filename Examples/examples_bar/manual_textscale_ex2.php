<?php

/**
 * JPGraph v3.6.21
 */
require_once __DIR__ . '/../../src/config.inc.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

// new Graph\Graph with a drop shadow
$__width  = 300;
$__height = 200;
$graph    = new Graph\Graph($__width, $__height);
$graph->SetShadow();

// Some data
$databary = [];
for ($i = 0; $i < 12; ++$i) {
    $databary[$i] = rand(1, 20);
}
$months = $graph->gDateLocale->GetShortMonth();
// Use a "text" X-scale
$graph->SetScale('textlin');

// Specify X-labels
$graph->xaxis->SetTickLabels($months);
$graph->xaxis->SetTextTickInterval(2, 0);

// Set title and subtitle
$graph->title->Set('Textscale with tickinterval=2');

// Use built in font
$graph->title->SetFont(FF_FONT1, FS_BOLD);

// Create the bar plot
$b1 = new Plot\BarPlot($databary);
$b1->SetLegend('Temperature');

// The order the plots are added determines who's ontop
$graph->Add($b1);

// Finally output the  image
$graph->Stroke();
