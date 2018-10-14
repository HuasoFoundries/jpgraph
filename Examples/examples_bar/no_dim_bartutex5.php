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
$graph    = new Graph\Graph($__width, $__height, 'auto');
$graph->SetShadow();

// Some data
$databary = [];
$databarx = [];
$months   = $graph->gDateLocale->GetShortMonth();

srand((float) microtime() * 1000000);
for ($i = 0; $i < 25; ++$i) {
    $databary[] = rand(1, 50);
    $databarx[] = $months[$i % 12];
}
// Use a "text" X-scale
$graph->SetScale('textlin');

// Specify X-labels
$graph->xaxis->SetTickLabels($databarx);
$graph->xaxis->SetTextLabelInterval(1);
$graph->xaxis->SetTextTickInterval(3);

// Set title and subtitle
$graph->title->Set('Bar tutorial example 5');

// Use built in font
$graph->title->SetFont(FF_FONT1, FS_BOLD);

// Create the bar plot
$b1 = new Plot\BarPlot($databary);
$b1->SetLegend('Temperature');
$b1->SetWidth(0.4);

// The order the plots are added determines who's ontop
$graph->Add($b1);

// Finally output the  image
$graph->Stroke();
